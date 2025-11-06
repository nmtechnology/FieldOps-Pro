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

echo "Environment check..."
echo "DB_CONNECTION: ${DB_CONNECTION:-not set}"
if [ -n "$DATABASE_URL" ]; then
    echo "DATABASE_URL is set"
else
    echo "DATABASE_URL not set"
fi

# Write environment variables to a file that PHP can read
echo "Writing environment to PHP-FPM..."
cat > /usr/local/etc/php-fpm.d/env.conf << ENVEOF
[www]
env[DB_CONNECTION] = ${DB_CONNECTION:-pgsql}
env[DATABASE_URL] = ${DATABASE_URL}
env[DB_HOST] = ${DB_HOST}
env[DB_PORT] = ${DB_PORT}
env[DB_DATABASE] = ${DB_DATABASE}
env[DB_USERNAME] = ${DB_USERNAME}
env[DB_PASSWORD] = ${DB_PASSWORD}
env[APP_KEY] = ${APP_KEY}
env[APP_ENV] = ${APP_ENV:-production}
env[APP_DEBUG] = ${APP_DEBUG:-false}
env[APP_URL] = ${APP_URL}
env[SESSION_DRIVER] = ${SESSION_DRIVER:-database}
env[QUEUE_CONNECTION] = ${QUEUE_CONNECTION:-database}
env[CACHE_DRIVER] = ${CACHE_DRIVER:-database}
ENVEOF

echo "Setting permissions..."
chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

echo "Starting services..."
# Start supervisor with php-fpm and nginx
/usr/sbin/supervisord -c /etc/supervisord.conf &
SUPERVISOR_PID=$!

echo "Waiting for services to start..."
sleep 5

echo "Running Laravel setup..."
(
    # Ensure environment is available to PHP
    export DB_CONNECTION="${DB_CONNECTION:-pgsql}"
    export DATABASE_URL="${DATABASE_URL}"
    export DB_HOST="${DB_HOST}"
    export DB_PORT="${DB_PORT}"
    export DB_DATABASE="${DB_DATABASE}"
    export DB_USERNAME="${DB_USERNAME}"
    export DB_PASSWORD="${DB_PASSWORD}"
    
    # CRITICAL: Clear any cached config that might have wrong DB settings
    echo "Clearing config cache..."
    php artisan config:clear 2>/dev/null || true
    rm -f bootstrap/cache/config.php 2>/dev/null || true
    
    # Storage link first (doesn't need DB)
    php artisan storage:link 2>/dev/null || true
    
    # Wait for database and migrate
    echo "Waiting for database..."
    for i in 1 2 3 4 5 6 7 8 9 10; do
        if php artisan migrate --force --no-interaction 2>&1; then
            echo "Migrations completed"
            break
        fi
        echo "Database not ready, waiting... ($i/10)"
        sleep 3
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
