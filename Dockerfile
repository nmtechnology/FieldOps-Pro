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

echo "=== Environment Check ==="
echo "DB_CONNECTION: ${DB_CONNECTION:-not set}"
if [ -n "$DATABASE_URL" ]; then
    echo "DATABASE_URL: set (length: ${#DATABASE_URL})"
else
    echo "DATABASE_URL: NOT SET!"
fi
echo "DB_HOST: ${DB_HOST:-not set}"
echo "DB_DATABASE: ${DB_DATABASE:-not set}"

# Create .env file from environment variables
echo "=== Creating .env file ==="
cat > /var/www/html/.env << ENVEOF
APP_NAME="${APP_NAME:-FieldEngineer Pro}"
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL}

LOG_CHANNEL=${LOG_CHANNEL:-stack}

DB_CONNECTION=${DB_CONNECTION:-pgsql}
DATABASE_URL=${DATABASE_URL}
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

CACHE_DRIVER=${CACHE_DRIVER:-database}
SESSION_DRIVER=${SESSION_DRIVER:-database}
QUEUE_CONNECTION=${QUEUE_CONNECTION:-database}

STRIPE_KEY=${STRIPE_KEY}
STRIPE_SECRET=${STRIPE_SECRET}
STRIPE_WEBHOOK_SECRET=${STRIPE_WEBHOOK_SECRET}

COINBASE_COMMERCE_API_KEY=${COINBASE_COMMERCE_API_KEY}
COINBASE_COMMERCE_WEBHOOK_SECRET=${COINBASE_COMMERCE_WEBHOOK_SECRET}
ENVEOF

echo ".env file created"
cat /var/www/html/.env | grep "DB_" | sed 's/PASSWORD=.*/PASSWORD=***/'

echo "=== Setting permissions ==="
chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/.env 2>/dev/null || true
chmod 600 /var/www/html/.env

echo "=== Starting services ==="
# Start supervisor with php-fpm and nginx
/usr/sbin/supervisord -c /etc/supervisord.conf &
SUPERVISOR_PID=$!

echo "Waiting for services to start..."
sleep 5

echo "=== Running Laravel setup ==="
(
    # CRITICAL: Clear any cached config
    echo "Clearing cached config..."
    php artisan config:clear 2>/dev/null || true
    rm -f bootstrap/cache/config.php 2>/dev/null || true
    
    # Debug: Show what Laravel sees
    echo "=== Laravel Configuration Check ==="
    php artisan tinker --execute="echo 'DB Connection: ' . config('database.default'); echo PHP_EOL; echo 'DB Driver: ' . config('database.connections.' . config('database.default') . '.driver'); echo PHP_EOL;" 2>&1 || echo "Tinker check failed"
    
    # Storage link first (doesn't need DB)
    php artisan storage:link 2>/dev/null || true
    
    # Wait for database and migrate
    echo "=== Starting migrations ==="
    for i in 1 2 3 4 5 6 7 8 9 10; do
        echo "Migration attempt $i/10..."
        if php artisan migrate --force --no-interaction 2>&1; then
            echo "✓ Migrations completed successfully"
            break
        fi
        if [ $i -eq 10 ]; then
            echo "✗ Migrations failed after 10 attempts"
        else
            echo "Waiting 5 seconds before retry..."
            sleep 5
        fi
    done
    
    # Cache after migrations (when DB is available)
    php artisan config:cache 2>/dev/null || true
    php artisan route:cache 2>/dev/null || true
    php artisan view:cache 2>/dev/null || true
    
    echo "Laravel setup complete!"
) &

# Wait for supervisor
wait $SUPERVISOR_PID
EOF

RUN chmod +x /start.sh

EXPOSE 8080

# Container health check
HEALTHCHECK --interval=10s --timeout=3s --start-period=60s --retries=3 \
    CMD /usr/local/bin/health-check

CMD ["/start.sh"]
