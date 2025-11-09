#!/bin/bash

# Deployment script for FieldOps-Pro discount system fixes
# Run this on the production server after SSH'ing in

echo "================================"
echo "FieldOps-Pro Deployment Script"
echo "================================"
echo ""

# Navigate to project directory
cd /var/www/fieldops-pro || exit 1

# Pull latest code (should already be done)
echo "✓ Code already pulled"
echo ""

# Build frontend assets
echo "=== Building frontend assets ==="
npm run build
echo ""

# Clear Laravel caches
echo "=== Clearing Laravel caches ==="
php artisan optimize
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
echo ""

# Set correct permissions
echo "=== Setting permissions ==="
chown -R www-data:www-data /var/www/fieldops-pro
chmod -R 755 /var/www/fieldops-pro
chmod -R 775 /var/www/fieldops-pro/storage
chmod -R 775 /var/www/fieldops-pro/bootstrap/cache
echo ""

# Restart services
echo "=== Restarting services ==="
systemctl restart php8.3-fpm
systemctl restart nginx
php artisan queue:restart
echo ""

echo "================================"
echo "✅ Deployment Complete!"
echo "================================"
echo ""
echo "Test the discount system at:"
echo "https://fieldengineerpro.com/admin/discounts"
echo ""
