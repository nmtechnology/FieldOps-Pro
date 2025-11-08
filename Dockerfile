FROM php:8.2-fpm-alpine

# Build timestamp: forces fresh build
ENV BUILD_DATE=2025-11-07

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

# Install PHP extensions (PostgreSQL only, NO SQLite)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    zip \
    gd \
    opcache

# Explicitly remove any SQLite packages if they exist
RUN apk del sqlite sqlite-dev 2>/dev/null || true
RUN rm -f /usr/local/lib/php/extensions/*/pdo_sqlite.so 2>/dev/null || true
RUN rm -f /usr/local/lib/php/extensions/*/sqlite3.so 2>/dev/null || true

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Restore composer.json if it was backed up to avoid buildpack detection
RUN if [ -f /var/www/html/composer.json.backup ]; then \
        cp /var/www/html/composer.json.backup /var/www/html/composer.json; \
    fi

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Install Node and build frontend assets
RUN apk add --no-cache nodejs npm
RUN npm ci --legacy-peer-deps --no-audit
RUN npm run build
RUN rm -rf node_modules

# Make startup script executable and set permissions
RUN chmod +x /start.sh && \
    chown -R nginx:nginx /var/www/html && \
    chmod -R 755 /var/www/html/storage

# Copy and set up health check script
COPY health-check.sh /usr/local/bin/health-check
RUN chmod +x /usr/local/bin/health-check

# Configure nginx
RUN mkdir -p /etc/nginx/http.d && \
    rm -f /etc/nginx/http.d/default.conf

COPY nginx.conf /etc/nginx/nginx.conf

# Configure supervisor
COPY supervisord.conf /etc/supervisord.conf

# Configure PHP-FPM to listen on TCP
RUN sed -i 's/listen = .*/listen = 127.0.0.1:9000/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/;clear_env = no/clear_env = no/' /usr/local/etc/php-fpm.d/www.conf

# Create directory structure and setup scripts
RUN mkdir -p /var/log/supervisor /var/log/nginx

# Copy and prepare startup script
COPY scripts/start.sh /start.sh
RUN chmod +x /start.sh

# Configure environment variables
ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stack \
    DB_CONNECTION=pgsql \
    CACHE_DRIVER=database \
    SESSION_DRIVER=database \
    QUEUE_CONNECTION=database

# Expose port for web traffic
EXPOSE 8080

# Container health check
HEALTHCHECK --interval=10s --timeout=3s --start-period=60s --retries=3 \
    CMD /usr/local/bin/health-check

# Create Procfile to disable buildpack detection
RUN echo "web: docker-container" > Procfile.web

# Start using the startup script
CMD ["/start.sh"]
