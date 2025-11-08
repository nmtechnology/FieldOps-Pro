#!/bin/sh
set -e

echo "🏥 Health Check Starting - $(date)"

# Check 1: Nginx process and port 8080
echo "1️⃣ Checking Nginx on port 8080..."
if ! pgrep nginx > /dev/null; then
    echo "❌ Nginx process not running"
    exit 1
fi

if ! netstat -tuln 2>/dev/null | grep -q ':8080' && ! ss -tuln 2>/dev/null | grep -q ':8080'; then
    echo "❌ Nginx not listening on port 8080"
    exit 1
fi
echo "✅ Nginx running on port 8080"

# Check 2: PHP-FPM process
echo "2️⃣ Checking PHP-FPM..."
if ! pgrep php-fpm > /dev/null; then
    echo "❌ PHP-FPM process not running"
    exit 1
fi
echo "✅ PHP-FPM running"

# Check 3: Supervisord
echo "3️⃣ Checking Supervisord..."
if ! pgrep supervisord > /dev/null; then
    echo "❌ Supervisord is not running"
    exit 1
fi
echo "✅ Supervisord running"

# Check 4: Database connection
echo "4️⃣ Checking database connection..."
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
echo "✅ Database connection successful"

# Check 5: HTTP response on port 8080
echo "5️⃣ Checking HTTP response..."
if command -v curl > /dev/null; then
    HTTP_CODE=$(curl -sf -o /dev/null -w "%{http_code}" http://localhost:8080/health 2>/dev/null || echo "000")
else
    HTTP_CODE=$(wget --spider --server-response http://localhost:8080/health 2>&1 | grep "HTTP/" | awk '{print $2}' | head -1 || echo "000")
fi

if [ "$HTTP_CODE" = "000" ] || [ -z "$HTTP_CODE" ]; then
    echo "❌ No HTTP response from localhost:8080"
    exit 1
fi
echo "✅ HTTP responding with code: $HTTP_CODE"

# Check 6: Required directories writable
echo "6️⃣ Checking storage permissions..."
if [ ! -w "/var/www/html/storage" ] || [ ! -w "/var/www/html/bootstrap/cache" ]; then
    echo "❌ Storage directories not writable"
    exit 1
fi
echo "✅ Storage writable"

echo "✅✅✅ All health checks passed! ✅✅✅"
exit 0
