#!/bin/bash

################################################################################
# FieldOps-Pro Server Provisioning Script
# For: Ubuntu 22.04/24.04 on DigitalOcean Droplet
# Purpose: Set up LEPP stack (Linux, Nginx, PostgreSQL, PHP 8.2)
################################################################################

set -e

echo "=========================================="
echo "🚀 FieldOps-Pro Server Provisioning"
echo "=========================================="

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    echo "❌ Please run as root (use sudo)"
    exit 1
fi

# Update system
echo "📦 Updating system packages..."
apt-get update
apt-get upgrade -y

# Install basic utilities
echo "🔧 Installing utilities..."
apt-get install -y curl wget git unzip software-properties-common

# Add PHP repository
echo "📦 Adding PHP 8.2 repository..."
add-apt-repository -y ppa:ondrej/php
apt-get update

# Install PHP 8.2 and extensions
echo "🐘 Installing PHP 8.2..."
apt-get install -y \
    php8.2-fpm \
    php8.2-cli \
    php8.2-common \
    php8.2-pgsql \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-bcmath \
    php8.2-curl \
    php8.2-gd \
    php8.2-zip \
    php8.2-intl \
    php8.2-redis

# Install PostgreSQL 16
echo "🐘 Installing PostgreSQL 16..."
apt-get install -y postgresql-16 postgresql-client-16

# Install Redis
echo "🔴 Installing Redis..."
apt-get install -y redis-server

# Install Nginx
echo "🌐 Installing Nginx..."
apt-get install -y nginx

# Install Supervisor
echo "👷 Installing Supervisor..."
apt-get install -y supervisor

# Install Node.js 20 (for asset compilation)
echo "📦 Installing Node.js 20..."
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt-get install -y nodejs

# Install Composer
echo "🎵 Installing Composer..."
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configure PHP-FPM
echo "⚙️ Configuring PHP-FPM..."
sed -i 's/upload_max_filesize = .*/upload_max_filesize = 100M/' /etc/php/8.2/fpm/php.ini
sed -i 's/post_max_size = .*/post_max_size = 100M/' /etc/php/8.2/fpm/php.ini
sed -i 's/memory_limit = .*/memory_limit = 512M/' /etc/php/8.2/fpm/php.ini
sed -i 's/max_execution_time = .*/max_execution_time = 300/' /etc/php/8.2/fpm/php.ini

# Create deployment user
echo "👤 Creating deployment user..."
if ! id -u deployer > /dev/null 2>&1; then
    useradd -m -s /bin/bash deployer
    usermod -aG www-data deployer
    echo "deployer ALL=(ALL) NOPASSWD: /usr/sbin/service php8.2-fpm reload, /usr/sbin/service nginx reload, /usr/bin/supervisorctl" | tee /etc/sudoers.d/deployer
fi

# Create application directory
echo "📁 Creating application directory..."
mkdir -p /var/www/fieldops-pro
chown -R deployer:www-data /var/www/fieldops-pro

# Setup PostgreSQL database
echo "🗄️ Setting up PostgreSQL..."
sudo -u postgres psql -c "CREATE DATABASE fieldops_pro;" 2>/dev/null || echo "Database already exists"
sudo -u postgres psql -c "CREATE USER fieldops_user WITH PASSWORD 'CHANGE_THIS_PASSWORD';" 2>/dev/null || echo "User already exists"
sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE fieldops_pro TO fieldops_user;"
sudo -u postgres psql -c "ALTER DATABASE fieldops_pro OWNER TO fieldops_user;"

# Configure PostgreSQL for network access
echo "⚙️ Configuring PostgreSQL..."
PG_HBA="/etc/postgresql/16/main/pg_hba.conf"
if ! grep -q "fieldops_user" "$PG_HBA"; then
    echo "host    fieldops_pro    fieldops_user    127.0.0.1/32    md5" >> "$PG_HBA"
fi
systemctl restart postgresql

# Start services
echo "🚀 Starting services..."
systemctl enable php8.2-fpm
systemctl start php8.2-fpm
systemctl enable nginx
systemctl start nginx
systemctl enable redis-server
systemctl start redis-server
systemctl enable supervisor
systemctl start supervisor

# Configure firewall
echo "🔥 Configuring UFW firewall..."
ufw --force enable
ufw allow 22/tcp    # SSH
ufw allow 80/tcp    # HTTP
ufw allow 443/tcp   # HTTPS

# Create SSH directory for deployer
echo "🔑 Setting up SSH for deployer..."
mkdir -p /home/deployer/.ssh
chmod 700 /home/deployer/.ssh
touch /home/deployer/.ssh/authorized_keys
chmod 600 /home/deployer/.ssh/authorized_keys
chown -R deployer:deployer /home/deployer/.ssh

echo ""
echo "=========================================="
echo "✅ Server provisioning completed!"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Add your SSH public key to: /home/deployer/.ssh/authorized_keys"
echo "2. Change PostgreSQL password in this script and re-run database setup"
echo "3. Update database credentials in your .env file"
echo "4. Run deploy.sh to deploy the application"
echo ""
echo "Database credentials (CHANGE THESE!):"
echo "  Database: fieldops_pro"
echo "  User: fieldops_user"
echo "  Password: CHANGE_THIS_PASSWORD"
echo ""
