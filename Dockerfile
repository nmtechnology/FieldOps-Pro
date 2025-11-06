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

echo "=== FieldOps-Pro Container Startup ==="
echo "DB_CONNECTION: ${DB_CONNECTION:-not set}"
echo "DATABASE_URL: $([ -n "$DATABASE_URL" ] && echo 'set' || echo 'NOT SET')"

# Create .env file BEFORE starting any services
echo "=== Creating .env file ==="
cat > /var/www/html/.env << 'ENVEOF'
APP_NAME="FieldEngineer Pro"
APP_ENV=production
APP_KEY=ENVEOF
echo "$APP_KEY" >> /var/www/html/.env
cat >> /var/www/html/.env << 'ENVEOF'
APP_DEBUG=false
APP_URL=ENVEOF
echo "$APP_URL" >> /var/www/html/.env
cat >> /var/www/html/.env << 'ENVEOF'
LOG_CHANNEL=stack
DB_CONNECTION=ENVEOF
echo "${DB_CONNECTION:-pgsql}" >> /var/www/html/.env
cat >> /var/www/html/.env << 'ENVEOF'
DATABASE_URL=ENVEOF
echo "$DATABASE_URL" >> /var/www/html/.env
cat >> /var/www/html/.env << 'ENVEOF'
DB_HOST=ENVEOF
echo "$DB_HOST" >> /var/www/html/.env
cat >> /var/www/html/.env << 'ENVEOF'
DB_PORT=ENVEOF
echo "$DB_PORT" >> /var/www/html/.env
cat >> /var/www/html/.env << 'ENVEOF'
DB_DATABASE=ENVEOF
echo "$DB_DATABASE" >> /var/www/html/.env
cat >> /var/www/html/.env << 'ENVEOF'
DB_USERNAME=ENVEOF
echo "$DB_USERNAME" >> /var/www/html/.env
cat >> /var/www/html/.env << 'ENVEOF'
DB_PASSWORD=ENVEOF
echo "$DB_PASSWORD" >> /var/www/html/.env
cat >> /var/www/html/.env << 'ENVEOF'
CACHE_DRIVER=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
STRIPE_KEY=ENVEOF
echo "$STRIPE_KEY" >> /var/www/html/.env
cat >> /var/www/html/.env << 'ENVEOF'
STRIPE_SECRET=ENVEOF
echo "$STRIPE_SECRET" >> /var/www/html/.env
cat >> /var/www/html/.env << 'ENVEOF'
STRIPE_WEBHOOK_SECRET=ENVEOF
echo "$STRIPE_WEBHOOK_SECRET" >> /var/www/html/.env
cat >> /var/www/html/.env << 'ENVEOF'
COINBASE_COMMERCE_API_KEY=ENVEOF
echo "$COINBASE_COMMERCE_API_KEY" >> /var/www/html/.env
cat >> /var/www/html/.env << 'ENVEOF'
COINBASE_COMMERCE_WEBHOOK_SECRET=ENVEOF
echo "$COINBASE_COMMERCE_WEBHOOK_SECRET" >> /var/www/html/.env

echo ".env file created successfully"
chmod 600 /var/www/html/.env
chown nginx:nginx /var/www/html/.env

echo "=== Setting permissions ==="
chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache

echo "=== Starting PHP-FPM and nginx ==="
/usr/sbin/supervisord -c /etc/supervisord.conf &
SUPERVISOR_PID=$!

sleep 3

echo "=== Running Laravel migrations ==="
for i in 1 2 3 4 5 6 7 8 9 10; do
    echo "Attempt $i/10: Running migrations..."
    if php artisan migrate --force --no-interaction 2>&1; then
        echo "✓ Migrations successful"
        break
    fi
    echo "Migration failed, retrying in 5 seconds..."
    sleep 5
done

echo "=== Caching configuration ==="
php artisan config:cache 2>/dev/null || echo "Config cache failed (continuing anyway)"
php artisan route:cache 2>/dev/null || echo "Route cache failed (continuing anyway)"
php artisan view:cache 2>/dev/null || echo "View cache failed (continuing anyway)"

echo "=== Startup complete ==="

# Wait for supervisor to keep container running
wait $SUPERVISOR_PID
EOF

RUN chmod +x /start.sh

EXPOSE 8080

# Container health check
HEALTHCHECK --interval=10s --timeout=3s --start-period=60s --retries=3 \
    CMD /usr/local/bin/health-check

CMD ["/start.sh"]
