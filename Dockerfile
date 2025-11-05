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
RUN rm -f /etc/nginx/sites-available/default.conf
COPY <<'EOF' /etc/nginx/sites-available/default.conf
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
        fastcgi_pass unix:/var/run/php-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
        fastcgi_connect_timeout 10s;
        fastcgi_send_timeout 60s;
        fastcgi_read_timeout 60s;
        fastcgi_buffering off;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

# Create start script
RUN cat > /start.sh << 'EOF'
#!/bin/sh

echo "Starting services immediately..."
# Start nginx and php-fpm in background
/usr/bin/supervisord -c /etc/supervisord.conf &
SUPERVISOR_PID=$!

echo "Running Laravel setup in background..."
(
    # Wait a moment for services to start
    sleep 2
    
    # Clear config cache (fast operation)
    php artisan config:clear
    
    # Storage link
    php artisan storage:link || true
    
    # Wait for database to be ready and migrate
    echo "Waiting for database..."
    for i in 1 2 3 4 5 6 7 8 9 10; do
        if php artisan migrate --force --no-interaction 2>/dev/null; then
            echo "Migrations completed"
            break
        fi
        echo "Database not ready, waiting... ($i/10)"
        sleep 3
    done
    
    # Cache configuration (do this after migrations)
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    
    echo "Laravel setup complete!"
) &

# Wait for supervisor process
wait $SUPERVISOR_PID
EOF

RUN chmod +x /start.sh

EXPOSE 8080

# Container health check
HEALTHCHECK --interval=10s --timeout=3s --start-period=60s --retries=3 \
    CMD /usr/local/bin/health-check

CMD ["/start.sh"]
