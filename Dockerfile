FROM php:8.2-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    postgresql-dev \
    curl \
    wget \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    zip \
    gd \
    opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Install Node and build frontend assets
RUN apk add --no-cache nodejs npm
RUN npm ci --legacy-peer-deps --no-audit
RUN npm run build
RUN rm -rf node_modules

# Set permissions
RUN chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy and set up health check script
COPY health-check.sh /usr/local/bin/health-check
RUN chmod +x /usr/local/bin/health-check

# Configure nginx
RUN mkdir -p /etc/nginx/http.d && \
    rm -f /etc/nginx/http.d/default.conf

RUN cat > /etc/nginx/nginx.conf << 'EOF'
user nginx;
worker_processes auto;
error_log /var/log/nginx/error.log warn;
pid /var/run/nginx.pid;

events {
    worker_connections 1024;
}

http {
    include /etc/nginx/mime.types;
    default_type application/octet-stream;
    
    log_format main '$remote_addr - $remote_user [$time_local] "$request" '
                    '$status $body_bytes_sent "$http_referer" '
                    '"$http_user_agent" "$http_x_forwarded_for"';
    
    access_log /var/log/nginx/access.log main;
    
    sendfile on;
    tcp_nopush on;
    keepalive_timeout 65;
    gzip on;
    
    server {
        listen 8080;
        server_name _;
        root /var/www/html/public;
        index index.php index.html;
        
        add_header X-Frame-Options "SAMEORIGIN";
        add_header X-Content-Type-Options "nosniff";
        
        charset utf-8;
        
        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }
        
        location = /favicon.ico { access_log off; log_not_found off; }
        location = /robots.txt  { access_log off; log_not_found off; }
        
        error_page 404 /index.php;
        
        location ~ \.php$ {
            fastcgi_pass 127.0.0.1:9000;
            fastcgi_index index.php;
            fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
            include fastcgi_params;
            fastcgi_hide_header X-Powered-By;
            fastcgi_connect_timeout 10s;
            fastcgi_send_timeout 60s;
            fastcgi_read_timeout 60s;
        }
        
        location ~ /\.(?!well-known).* {
            deny all;
        }
    }
}
EOF

# Configure supervisor
RUN cat > /etc/supervisord.conf << 'EOF'
[supervisord]
nodaemon=true
user=root
logfile=/var/log/supervisor/supervisord.log
pidfile=/var/run/supervisord.pid

[program:php-fpm]
command=php-fpm --nodaemonize --fpm-config /usr/local/etc/php-fpm.d/www.conf
autostart=true
autorestart=true
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0

[program:nginx]
command=nginx -g 'daemon off;'
autostart=true
autorestart=true
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
EOF

# Configure PHP-FPM to listen on TCP
RUN sed -i 's/listen = .*/listen = 127.0.0.1:9000/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/;clear_env = no/clear_env = no/' /usr/local/etc/php-fpm.d/www.conf

# Create directories
RUN mkdir -p /var/log/supervisor /var/log/nginx

# Create start script
RUN cat > /start.sh << 'EOF'
#!/bin/sh
set -e

echo "======================================"
echo "FIELDOPS-PRO CUSTOM DOCKERFILE STARTUP"
echo "======================================"
echo "DB_CONNECTION env var: ${DB_CONNECTION:-MISSING}"
echo "DATABASE_URL env var: $([ -n "$DATABASE_URL" ] && echo 'SET' || echo 'MISSING')"

# Force create .env with hardcoded pgsql to test
echo "Creating .env file with hardcoded pgsql..."
cat > /var/www/html/.env << 'ENVEOF'
APP_NAME="FieldEngineer Pro"
APP_ENV=production
APP_DEBUG=false
LOG_CHANNEL=stack
DB_CONNECTION=pgsql
CACHE_DRIVER=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
ENVEOF

# Add dynamic values
echo "APP_KEY=${APP_KEY}" >> /var/www/html/.env
echo "APP_URL=${APP_URL}" >> /var/www/html/.env
echo "DATABASE_URL=${DATABASE_URL}" >> /var/www/html/.env
echo "DB_HOST=${DB_HOST}" >> /var/www/html/.env
echo "DB_PORT=${DB_PORT}" >> /var/www/html/.env
echo "DB_DATABASE=${DB_DATABASE}" >> /var/www/html/.env
echo "DB_USERNAME=${DB_USERNAME}" >> /var/www/html/.env
echo "DB_PASSWORD=${DB_PASSWORD}" >> /var/www/html/.env

echo ".env file created. Contents:"
cat /var/www/html/.env | head -10

chmod 600 /var/www/html/.env
chown nginx:nginx /var/www/html/.env
chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache

echo "Starting supervisor..."
/usr/sbin/supervisord -c /etc/supervisord.conf &
SUPERVISOR_PID=$!

sleep 5

echo "Testing database connection..."
php artisan tinker --execute="
    echo 'Laravel default DB: ' . config('database.default') . PHP_EOL;
    echo 'Trying connection...';
    try {
        DB::connection()->getPdo();
        echo 'SUCCESS: Connected to database' . PHP_EOL;
    } catch (Exception \$e) {
        echo 'ERROR: ' . \$e->getMessage() . PHP_EOL;
    }
" 2>&1

echo "Running migrations..."
php artisan migrate --force --no-interaction || echo "Migration failed"

echo "Startup complete - waiting for supervisor"
wait $SUPERVISOR_PID
EOF

RUN chmod +x /start.sh

EXPOSE 8080

# Container health check
HEALTHCHECK --interval=10s --timeout=3s --start-period=60s --retries=3 \
    CMD /usr/local/bin/health-check

CMD ["/start.sh"]
