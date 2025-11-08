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

# Debug: Show URL parsing
if [ -n "$DATABASE_URL" ]; then
    echo "Found DATABASE_URL, parsing components..."
    # Parse DATABASE_URL into components
    # Format: postgres://username:password@hostname:port/database
    DB_SCHEME=$(echo "$DATABASE_URL" | sed -E 's/^(.*):\/\/.*/\1/')
    DB_USER=$(echo "$DATABASE_URL" | sed -E 's/.*:\/\/([^:]*).*/\1/')
    DB_PASS=$(echo "$DATABASE_URL" | sed -E 's/.*:\/\/[^:]*:([^@]*)@.*/\1/')
    DB_HOST=$(echo "$DATABASE_URL" | sed -E 's/.*@([^:]*).*/\1/')
    DB_PORT=$(echo "$DATABASE_URL" | sed -E 's/.*:([0-9]*)\\/.*/\1/')
    DB_NAME=$(echo "$DATABASE_URL" | sed -E 's/.*\/([^?]*).*/\1/')
    
    echo "✅ Parsed database configuration:"
    echo "- Scheme: $DB_SCHEME"
    echo "- Host: $DB_HOST"
    echo "- Port: $DB_PORT"
    echo "- Database: $DB_NAME"
    echo "- User: $DB_USER"
    echo "- Password: [REDACTED]"
fi

echo "📝 Creating .env file..."
# Parse DATABASE_URL if present
if [ -n "$DATABASE_URL" ]; then
    echo "🔍 Parsing DATABASE_URL: ${DATABASE_URL}"
    
    # Extract components using pattern matching
    DB_USER=$(echo "$DATABASE_URL" | sed -n 's/^postgres:\/\/\([^:]*\):.*/\1/p')
    DB_PASS=$(echo "$DATABASE_URL" | sed -n 's/^postgres:\/\/[^:]*:\([^@]*\)@.*/\1/p')
    DB_HOST=$(echo "$DATABASE_URL" | sed -n 's/^postgres:\/\/[^@]*@\([^:]*\):.*/\1/p')
    DB_PORT=$(echo "$DATABASE_URL" | sed -n 's/^postgres:\/\/[^@]*@[^:]*:\([^/]*\)\/.*/\1/p')
    DB_NAME=$(echo "$DATABASE_URL" | sed -n 's/^postgres:\/\/[^@]*@[^/]*\/\(.*\)$/\1/p')
    
    # Log parsed components (masking password)
    echo "✅ Parsed DATABASE_URL components:"
    echo "  - Host: ${DB_HOST}"
    echo "  - Port: ${DB_PORT}"
    echo "  - Database: ${DB_NAME}"
    echo "  - User: ${DB_USER}"
    echo "  - Password: [MASKED]"
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
[ -n "$APP_KEY" ] && echo "APP_KEY=${APP_KEY}" >> /var/www/html/.env
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

echo "🚀 Starting services..."
exec /usr/sbin/supervisord -c /etc/supervisord.conf -n