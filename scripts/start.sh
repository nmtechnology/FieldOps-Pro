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

# Database configuration
if [ -n "$DATABASE_URL" ]; then
    echo "DATABASE_URL=${DATABASE_URL}" >> /var/www/html/.env
    echo "✅ DATABASE_URL is set"
    
    if [ -z "$DB_HOST" ]; then
        echo "⚠️  Individual DB vars not set, will parse DATABASE_URL"
        echo "Laravel will use DATABASE_URL directly"
    fi
else
    echo "❌ DATABASE_URL is NOT set"
fi

# Add individual DB variables if they have values
[ -n "$DB_HOST" ] && echo "DB_HOST=${DB_HOST}" >> /var/www/html/.env && echo "✅ DB_HOST is set to: ${DB_HOST}"
[ -n "$DB_PORT" ] && echo "DB_PORT=${DB_PORT}" >> /var/www/html/.env && echo "✅ DB_PORT is set to: ${DB_PORT}"
[ -n "$DB_DATABASE" ] && echo "DB_DATABASE=${DB_DATABASE}" >> /var/www/html/.env && echo "✅ DB_DATABASE is set"
[ -n "$DB_USERNAME" ] && echo "DB_USERNAME=${DB_USERNAME}" >> /var/www/html/.env && echo "✅ DB_USERNAME is set"
[ -n "$DB_PASSWORD" ] && echo "DB_PASSWORD=${DB_PASSWORD}" >> /var/www/html/.env && echo "✅ DB_PASSWORD is set"

echo "========================================"
echo "📄 Final .env file contents (DB vars only):"
cat /var/www/html/.env | grep -E "(DB_|DATABASE_)" || echo "❌ No DB vars in .env file!"
echo "========================================"

# Set permissions
chmod 600 /var/www/html/.env
chown nginx:nginx /var/www/html/.env
chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache

echo "🚀 Starting services..."
exec /usr/sbin/supervisord -c /etc/supervisord.conf -n