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

# Debug: Show all environment variables (redacted)
echo "ALL ENV VARS (REDACTED):"
env | sed 's/\(password=\)[^[:space:]]*/\1******/g' | \
       sed 's/\(PASSWORD=\)[^[:space:]]*/\1******/g' | \
       sort

echo "📝 Creating .env file..."

# Check if we have DATABASE_URL
if [ -z "$DATABASE_URL" ]; then
    echo "⚠️ WARNING: DATABASE_URL is not set!"
    echo "  Will try to use individual DB_* variables instead"
    
    # Check if we have individual variables
    if [ -z "$DB_HOST" ] || [ -z "$DB_DATABASE" ]; then
        echo "❌ ERROR: Neither DATABASE_URL nor individual DB variables are set!"
        echo "  Available DB-related environment variables:"
        env | grep -i "db\|database" | sed 's/\(PASSWORD=\)[^[:space:]]*/\1******/g' || echo "  (none found)"
        exit 1
    fi
else
    echo "✅ DATABASE_URL is set"
    # Parse DATABASE_URL if present
    echo "🔍 Parsing DATABASE_URL..."
    
    # Extract components using pattern matching
    # Format: postgres://username:password@hostname:port/database?params
    DB_USER=$(echo "$DATABASE_URL" | sed -n 's/^postgres:\/\/\([^:]*\):.*/\1/p')
    DB_PASS=$(echo "$DATABASE_URL" | sed -n 's/^postgres:\/\/[^:]*:\([^@]*\)@.*/\1/p')
    DB_HOST=$(echo "$DATABASE_URL" | sed -n 's/^postgres:\/\/[^@]*@\([^:]*\):.*/\1/p')
    DB_PORT=$(echo "$DATABASE_URL" | sed -n 's/^postgres:\/\/[^@]*@[^:]*:\([^/?]*\).*/\1/p')
    DB_NAME=$(echo "$DATABASE_URL" | sed -n 's/^postgres:\/\/[^/]*\/\([^?]*\).*/\1/p')
    
    # Log parsed components (masking password)
    echo "✅ Parsed DATABASE_URL components:"
    echo "  - Host: ${DB_HOST}"
    echo "  - Port: ${DB_PORT}"
    echo "  - Database: ${DB_NAME}"
    echo "  - User: ${DB_USER}"
    echo "  - Password: [MASKED ${#DB_PASS} chars]"
    
    # Validate all components were parsed
    if [ -z "$DB_HOST" ] || [ -z "$DB_PORT" ] || [ -z "$DB_NAME" ] || [ -z "$DB_USER" ] || [ -z "$DB_PASS" ]; then
        echo "❌ ERROR: Failed to parse DATABASE_URL completely!"
        echo "  DATABASE_URL format: postgres://username:password@hostname:port/database"
        echo "  Parsed values:"
        echo "    DB_USER: ${DB_USER:-'(empty)'}"
        echo "    DB_HOST: ${DB_HOST:-'(empty)'}"
        echo "    DB_PORT: ${DB_PORT:-'(empty)'}"
        echo "    DB_NAME: ${DB_NAME:-'(empty)'}"
        exit 1
    fi
fi

# Environment template
cat << ENVEOF > /var/www/html/.env
APP_NAME=FieldOps-Pro
APP_ENV=production
APP_DEBUG=false
LOG_CHANNEL=stack
DB_CONNECTION=pgsql
CACHE_DRIVER=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
ENVEOF

# Add core environment variables
echo "📝 Adding core environment variables..."

# Validate critical environment variables
if [ -z "$APP_KEY" ]; then
    echo "❌ ERROR: APP_KEY environment variable is not set!"
    echo "  This is required for Laravel to function."
    exit 1
fi

echo "APP_KEY=${APP_KEY}" >> /var/www/html/.env
[ -n "$APP_URL" ] && echo "APP_URL=${APP_URL}" >> /var/www/html/.env

# Configure database connection
echo "📝 Setting up database connection..."
if [ -n "$DATABASE_URL" ]; then
    # Use parsed components from DATABASE_URL
    echo "DB_HOST=${DB_HOST}" >> /var/www/html/.env
    echo "DB_PORT=${DB_PORT}" >> /var/www/html/.env
    echo "DB_DATABASE=${DB_NAME}" >> /var/www/html/.env
    echo "DB_USERNAME=${DB_USER}" >> /var/www/html/.env
    echo "DB_PASSWORD=${DB_PASS}" >> /var/www/html/.env
    echo "DB_SSLMODE=require" >> /var/www/html/.env
    echo "✅ Database configured from DATABASE_URL"
else
    # Fall back to individual variables if present
    [ -n "$DB_HOST" ] && echo "DB_HOST=${DB_HOST}" >> /var/www/html/.env
    [ -n "$DB_PORT" ] && echo "DB_PORT=${DB_PORT}" >> /var/www/html/.env
    [ -n "$DB_DATABASE" ] && echo "DB_DATABASE=${DB_DATABASE}" >> /var/www/html/.env
    [ -n "$DB_USERNAME" ] && echo "DB_USERNAME=${DB_USERNAME}" >> /var/www/html/.env
    [ -n "$DB_PASSWORD" ] && echo "DB_PASSWORD=${DB_PASSWORD}" >> /var/www/html/.env
    [ -n "$DB_SSLMODE" ] && echo "DB_SSLMODE=${DB_SSLMODE}" >> /var/www/html/.env
    echo "⚠️ Using individual database variables"
fi

echo "========================================"
echo "📄 Final .env file contents (DB vars only):"
cat /var/www/html/.env | grep -E "(DB_|DATABASE_)" || echo "❌ No DB vars in .env file!"
echo "========================================"

# Set permissions
chmod 600 /var/www/html/.env
chown nginx:nginx /var/www/html/.env
chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache

# Test database connection before proceeding
echo "🔌 Testing database connection..."
if php artisan db:monitor --max-attempts=3 > /dev/null 2>&1; then
    echo "✅ Database connection successful!"
else
    echo "⚠️ Database connection test inconclusive, attempting migration anyway..."
fi

# Run migrations with detailed error handling
echo "🔄 Running database migrations..."
if php artisan migrate --force --no-interaction; then
    echo "✅ Database migrations completed successfully!"
else
    MIGRATION_EXIT_CODE=$?
    echo "❌ ERROR: Database migrations failed with exit code: ${MIGRATION_EXIT_CODE}"
    echo "📋 Checking migration status..."
    php artisan migrate:status || true
    echo "� Last 50 lines of Laravel logs:"
    tail -50 /var/www/html/storage/logs/laravel.log 2>/dev/null || echo "No log file found"
    echo "⚠️ CRITICAL: Application may not function correctly without migrations!"
    # Don't exit - let supervisor start services so we can debug
fi

# Clear and cache configuration
echo "🔧 Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "�🚀 Starting services..."
echo "   - Nginx listening on port 8080"
echo "   - PHP-FPM on 127.0.0.1:9000"
echo "   - Queue worker enabled"
echo "========================================"
exec /usr/sbin/supervisord -c /etc/supervisord.conf -n