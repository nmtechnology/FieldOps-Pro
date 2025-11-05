#!/bin/bash
set -e

echo "Starting deployment..."

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Run migrations
php artisan migrate --force --no-interaction

# Create symbolic link for storage
php artisan storage:link || true

# Cache configurations for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deployment completed successfully!"
