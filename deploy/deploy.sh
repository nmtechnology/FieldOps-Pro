#!/bin/bash

################################################################################
# FieldOps-Pro Deployment Script
# For: Ubuntu 22.04/24.04 on DigitalOcean Droplet
# Purpose: Deploy Laravel application from GitHub
################################################################################

set -e

# Configuration
APP_DIR="/var/www/fieldops-pro"
REPO_URL="https://github.com/nmtechnology/FieldOps-Pro.git"
BRANCH="main"
PHP_VERSION="8.2"

echo "=========================================="
echo "🚀 Deploying FieldOps-Pro"
echo "=========================================="

# Check if running as deployer user
if [ "$USER" != "deployer" ]; then
    echo "❌ This script must be run as the 'deployer' user"
    echo "   Run: sudo -u deployer bash deploy.sh"
    exit 1
fi

cd /var/www

# First-time setup
if [ ! -d "$APP_DIR/.git" ]; then
    echo "📦 First-time setup: Cloning repository..."
    git clone "$REPO_URL" fieldops-pro
    cd fieldops-pro
else
    echo "📦 Pulling latest changes..."
    cd fieldops-pro
    git fetch origin
    git reset --hard origin/$BRANCH
fi

# Install/update Composer dependencies
echo "🎵 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install/update Node dependencies and build assets
echo "📦 Building frontend assets..."
npm ci --legacy-peer-deps --no-audit
npm run build

# Set permissions
echo "🔒 Setting permissions..."
sudo chown -R deployer:www-data $APP_DIR
sudo chmod -R 755 $APP_DIR
sudo chmod -R 775 $APP_DIR/storage
sudo chmod -R 775 $APP_DIR/bootstrap/cache

# Check if .env exists
if [ ! -f "$APP_DIR/.env" ]; then
    echo "⚠️  No .env file found!"
    echo "   Creating from .env.example..."
    cp .env.example .env
    echo "   ⚠️  YOU MUST EDIT .env WITH YOUR CREDENTIALS!"
    echo "   Edit: nano $APP_DIR/.env"
    exit 1
fi

# Generate app key if needed
if ! grep -q "APP_KEY=base64:" .env; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# Run migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Clear and cache config
echo "⚡ Optimizing application..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart services
echo "🔄 Restarting services..."
sudo service php8.2-fpm reload
sudo service nginx reload

# Restart queue workers if supervisor is configured
if [ -f "/etc/supervisor/conf.d/fieldops-queue.conf" ]; then
    echo "🔄 Restarting queue workers..."
    sudo supervisorctl restart fieldops-queue:*
fi

echo ""
echo "=========================================="
echo "✅ Deployment completed successfully!"
echo "=========================================="
echo ""
echo "Application is now live at your domain"
echo ""
