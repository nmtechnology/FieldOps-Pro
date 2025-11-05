#!/bin/bash

# Run database migrations
php artisan migrate --force --no-interaction

# Create storage symlink
php artisan storage:link || true

# Clear and cache configs
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM and Nginx using Heroku buildpack
vendor/bin/heroku-php-nginx -C nginx.conf public/
