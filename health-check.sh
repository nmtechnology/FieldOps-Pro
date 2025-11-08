#!/bin/sh
set -e

echo "Starting health check..."

# Check services
if ! pgrep nginx > /dev/null; then
    echo "❌ nginx is not running"
    exit 1
fi

if ! pgrep php-fpm > /dev/null; then
    echo "❌ php-fpm is not running"
    exit 1
fi

if ! pgrep supervisord > /dev/null; then
    echo "❌ supervisord is not running"
    exit 1
fi

# Check if Laravel can connect to the database
cd /var/www/html
if ! php artisan db:monitor --quiet; then
    echo "❌ Database connection failed"
    echo "Current database configuration:"
    php artisan tinker --execute="
        echo 'DB_CONNECTION: ' . config('database.default') . PHP_EOL;
        echo 'DB_HOST: ' . config('database.connections.pgsql.host') . PHP_EOL;
        echo 'DB_PORT: ' . config('database.connections.pgsql.port') . PHP_EOL;
        echo 'DB_DATABASE: ' . config('database.connections.pgsql.database') . PHP_EOL;
        " 2>/dev/null || echo "Could not read database config"
    exit 1
fi

# Check if web server is responding
if command -v curl > /dev/null; then
    if ! curl -sf http://localhost:8080/health > /dev/null; then
        echo "❌ Web server not responding"
        exit 1
    fi
else
    if ! wget -q -O- http://localhost:8080/health > /dev/null; then
        echo "❌ Web server not responding"
        exit 1
    fi
fi

echo "✅ All health checks passed"
exit 0
