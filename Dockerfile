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

# Set permissions
RUN chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

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

# Create directories
RUN mkdir -p /var/log/supervisor /var/log/nginx

# Create start script
RUN cat > /start.sh << 'EOF'
#!/bin/sh
set -e

# Redirect all output to both stdout and a log file
exec 1> >(tee -a /var/log/startup.log)
exec 2>&1

# First thing - confirm the startup script is running
echo "=========================================="
echo "START SCRIPT EXECUTING - $(date)"
echo "PWD: $(pwd)"
echo "USER: $(whoami)"
echo "=========================================="

echo "========================================"
echo "🐘 POSTGRESQL-ONLY DEPLOYMENT STARTING"
echo "========================================"
echo "Checking environment variables..."
echo "ALL ENV VARS:"
env | grep -E "(DB_|DATABASE_)" | sort || echo "❌ No DB env vars found"
echo "========================================"

# Create .env file with PostgreSQL-only configuration
echo "📝 Creating .env file..."
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

# Add environment variables with explicit logging
echo "📝 Adding environment variables to .env..."
[ -n "$APP_KEY" ] && echo "APP_KEY=${APP_KEY}" >> /var/www/html/.env
[ -n "$APP_URL" ] && echo "APP_URL=${APP_URL}" >> /var/www/html/.env

# Check if DATABASE_URL is available and parse it if individual vars aren't set
if [ -n "$DATABASE_URL" ]; then
    echo "DATABASE_URL=${DATABASE_URL}" >> /var/www/html/.env
    echo "✅ DATABASE_URL is set"
    
    # If individual DB vars aren't set, try to parse DATABASE_URL
    # Format: postgresql://user:pass@host:port/database
    if [ -z "$DB_HOST" ]; then
        echo "⚠️  Individual DB vars not set, will parse DATABASE_URL"
        echo "Laravel will use DATABASE_URL directly"
    fi
else
    echo "❌ DATABASE_URL is NOT set"
fi

# Add individual DB variables if they have values
if [ -n "$DB_HOST" ]; then
    echo "DB_HOST=${DB_HOST}" >> /var/www/html/.env
    echo "✅ DB_HOST is set to: ${DB_HOST}"
fi

if [ -n "$DB_PORT" ]; then
    echo "DB_PORT=${DB_PORT}" >> /var/www/html/.env
    echo "✅ DB_PORT is set to: ${DB_PORT}"
fi

if [ -n "$DB_DATABASE" ]; then
    echo "DB_DATABASE=${DB_DATABASE}" >> /var/www/html/.env
    echo "✅ DB_DATABASE is set to: ${DB_DATABASE}"
fi

if [ -n "$DB_USERNAME" ]; then
    echo "DB_USERNAME=${DB_USERNAME}" >> /var/www/html/.env
    echo "✅ DB_USERNAME is set"
fi

if [ -n "$DB_PASSWORD" ]; then
    echo "DB_PASSWORD=${DB_PASSWORD}" >> /var/www/html/.env
    echo "✅ DB_PASSWORD is set"
fi

echo "========================================"
echo "📄 Final .env file contents (DB vars only):"
cat /var/www/html/.env | grep -E "(DB_|DATABASE_)" || echo "❌ No DB vars in .env file!"
echo "========================================"

chmod 600 /var/www/html/.env
chown nginx:nginx /var/www/html/.env
chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache

echo "🚀 Starting services..."
/usr/sbin/supervisord -c /etc/supervisord.conf &
SUPERVISOR_PID=$!

sleep 5

echo "🧪 Testing Laravel database config..."
php artisan tinker --execute="
echo 'Laravel DB default: ' . config('database.default') . PHP_EOL;
echo 'Laravel DB host: ' . config('database.connections.pgsql.host') . PHP_EOL;
echo 'Laravel DB port: ' . config('database.connections.pgsql.port') . PHP_EOL;
echo 'Laravel DB database: ' . config('database.connections.pgsql.database') . PHP_EOL;
" 2>&1 || echo "Tinker failed"

echo "🗄️ Running migrations..."
php artisan migrate --force --no-interaction || {
    echo "❌ Migration failed - clearing cache and retrying..."
    php artisan config:clear
    php artisan config:cache
    php artisan migrate --force --no-interaction
}

echo "✅ Startup complete - PostgreSQL only!"
wait $SUPERVISOR_PID
EOF

RUN chmod +x /start.sh

EXPOSE 8080

# Container health check
HEALTHCHECK --interval=10s --timeout=3s --start-period=60s --retries=3 \
    CMD /usr/local/bin/health-check

# Confirm Dockerfile build complete
RUN echo "DOCKERFILE BUILD COMPLETE - FieldOps-Pro PostgreSQL-only image" > /docker-build-complete.txt

# Start the application
CMD ["/start.sh"]
