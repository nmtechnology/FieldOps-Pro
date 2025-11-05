#!/bin/bash
set -e

echo "Starting FieldEngineer Pro..."

# Wait for database to be ready
echo "Waiting for database connection..."
for i in {1..30}; do
  php artisan db:show 2>/dev/null && break || {
    echo "Database not ready yet, waiting... ($i/30)"
    sleep 2
  }
done

# Run Laravel setup commands
echo "Running Laravel setup..."
php artisan config:clear
php artisan cache:clear
php artisan migrate --force --no-interaction
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link if needed
php artisan storage:link || true

# Start PHP built-in server
echo "Starting web server on 0.0.0.0:8080..."
exec php -S 0.0.0.0:8080 -t public/ public/index.php
