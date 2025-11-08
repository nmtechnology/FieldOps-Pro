# FieldOps-Pro Deployment Guide
## Traditional Droplet Deployment (Recommended)

This guide will help you deploy FieldOps-Pro to a DigitalOcean Droplet using a traditional LEPP stack (Linux, Nginx, PostgreSQL, PHP).

---

## Why This Approach?

✅ **Proven and reliable** - Traditional server setup used by millions of Laravel apps  
✅ **Simple to debug** - No Docker complexity  
✅ **Full control** - Complete access to your server  
✅ **Cost-effective** - $6-12/month for a droplet  
✅ **Fast deployment** - 30 minutes from zero to production  

---

## Prerequisites

- A DigitalOcean account
- A domain name (optional, can use IP initially)
- SSH key pair (or will create one)

---

## Step 1: Create a Droplet

1. Go to DigitalOcean → Create → Droplets
2. Choose configuration:
   - **Image**: Ubuntu 24.04 LTS
   - **Plan**: Basic
   - **CPU**: Regular (2GB RAM recommended, ~$18/month)
   - **Datacenter**: Choose closest to your users
   - **Authentication**: SSH key (add your public key)
   - **Hostname**: fieldops-pro

3. Click **Create Droplet**
4. Note your droplet's IP address (e.g., `134.209.xxx.xxx`)

---

## Step 2: Initial Server Setup

SSH into your droplet:
```bash
ssh root@YOUR_DROPLET_IP
```

Download and run the provisioning script:
```bash
curl -o provision.sh https://raw.githubusercontent.com/nmtechnology/FieldOps-Pro/main/deploy/provision.sh
chmod +x provision.sh
./provision.sh
```

This script installs:
- Nginx web server
- PHP 8.2 with all required extensions
- PostgreSQL 16 database
- Redis for caching
- Supervisor for queue workers
- Node.js for asset compilation
- Composer for PHP dependencies

**⏱️ Takes about 5-10 minutes**

---

## Step 3: Configure SSH Access for Deployer

After provisioning, add your SSH public key for the deployer user:

```bash
# On your local machine, copy your public key
cat ~/.ssh/id_rsa.pub

# On the server, as root
nano /home/deployer/.ssh/authorized_keys
# Paste your public key and save (Ctrl+X, Y, Enter)
```

Test SSH access:
```bash
# From your local machine
ssh deployer@YOUR_DROPLET_IP
```

---

## Step 4: Update Database Password

**IMPORTANT**: Change the default database password!

```bash
# As root on the server
sudo -u postgres psql
\password fieldops_user
# Enter your new secure password
\q
```

---

## Step 5: Configure Environment Variables

```bash
# As deployer user
cd /var/www/fieldops-pro

# Create .env file (on first deployment this happens automatically)
# If it doesn't exist yet, we'll create it during first deployment
```

---

## Step 6: Deploy the Application

```bash
# As deployer user
curl -o deploy.sh https://raw.githubusercontent.com/nmtechnology/FieldOps-Pro/main/deploy/deploy.sh
chmod +x deploy.sh
./deploy.sh
```

**First deployment will**:
- Clone the repository
- Install dependencies
- Build frontend assets
- Create .env file (you'll need to edit it)

If .env is created, the script will pause. Edit it:
```bash
nano /var/www/fieldops-pro/.env
```

Update these values:
```env
APP_NAME="FieldOps-Pro"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://YOUR_DROPLET_IP

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=fieldops_pro
DB_USERNAME=fieldops_user
DB_PASSWORD=YOUR_SECURE_PASSWORD

# Add your Stripe keys
STRIPE_KEY=pk_live_xxxxx
STRIPE_SECRET=sk_live_xxxxx
STRIPE_WEBHOOK_SECRET=whsec_xxxxx
```

Then run deploy again:
```bash
./deploy.sh
```

---

## Step 7: Configure Nginx

```bash
# As root
sudo cp /var/www/fieldops-pro/deploy/nginx-site.conf /etc/nginx/sites-available/fieldops-pro
sudo ln -s /etc/nginx/sites-available/fieldops-pro /etc/nginx/sites-enabled/

# Remove default site
sudo rm /etc/nginx/sites-enabled/default

# Test configuration
sudo nginx -t

# Reload Nginx
sudo service nginx reload
```

---

## Step 8: Setup Queue Workers (Optional but Recommended)

```bash
# As root
sudo cp /var/www/fieldops-pro/deploy/supervisor-queue.conf /etc/supervisor/conf.d/fieldops-queue.conf
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start fieldops-queue:*
```

---

## Step 9: Point Your Domain (Optional)

In your domain registrar (Namecheap, GoDaddy, etc.):

1. Add an **A Record**:
   - Host: `@`
   - Points to: `YOUR_DROPLET_IP`

2. Add a **CNAME Record** for www:
   - Host: `www`
   - Points to: `@` or your domain

**DNS propagation takes 5-60 minutes**

---

## Step 10: Setup SSL Certificate (After Domain Points)

Once your domain is pointing to your server:

```bash
# As root
sudo apt-get install -y certbot python3-certbot-nginx

# Get SSL certificate
sudo certbot --nginx -d fieldengineerpro.com -d www.fieldengineerpro.com

# Follow the prompts (enter your email, agree to terms)
```

Certbot will automatically:
- Get SSL certificates
- Configure Nginx
- Setup auto-renewal

---

## Automated Deployments (Optional)

### Setup GitHub Actions for Auto-Deploy

1. Add your server's SSH private key to GitHub Secrets:
   - Go to your repo → Settings → Secrets → New secret
   - Name: `DROPLET_SSH_KEY`
   - Value: Contents of your SSH private key

2. Add these secrets:
   - `DROPLET_HOST`: Your droplet IP or domain
   - `DROPLET_USER`: `deployer`

3. Push to main branch → Automatic deployment! 🚀

---

## Daily Operations

### Deploy Updates
```bash
ssh deployer@YOUR_DROPLET_IP
cd /var/www/fieldops-pro
./deploy.sh
```

### View Logs
```bash
# Laravel logs
tail -f /var/www/fieldops-pro/storage/logs/laravel.log

# Nginx error logs
sudo tail -f /var/log/nginx/fieldops-error.log

# Queue worker logs
tail -f /var/www/fieldops-pro/storage/logs/queue-worker.log
```

### Restart Services
```bash
# PHP-FPM
sudo service php8.2-fpm restart

# Nginx
sudo service nginx restart

# Queue workers
sudo supervisorctl restart fieldops-queue:*
```

### Run Artisan Commands
```bash
cd /var/www/fieldops-pro
php artisan cache:clear
php artisan migrate
php artisan tinker
```

---

## Troubleshooting

### 502 Bad Gateway
```bash
# Check PHP-FPM status
sudo service php8.2-fpm status

# Check PHP-FPM logs
sudo tail -f /var/log/php8.2-fpm.log
```

### Database Connection Error
```bash
# Test database connection
psql -h 127.0.0.1 -U fieldops_user -d fieldops_pro

# Check .env file
nano /var/www/fieldops-pro/.env
```

### Permission Errors
```bash
# Fix permissions
cd /var/www/fieldops-pro
sudo chown -R deployer:www-data .
sudo chmod -R 755 .
sudo chmod -R 775 storage bootstrap/cache
```

---

## Costs

- **Droplet**: $6-18/month (depending on size)
- **Managed PostgreSQL** (optional): $15/month
- **Total**: ~$6-35/month

Much simpler and more reliable than Docker on App Platform! 🎉

---

## Getting Help

If something isn't working:
1. Check the logs (see "View Logs" section)
2. Verify .env configuration
3. Check file permissions
4. Ensure all services are running

Most issues are related to:
- Incorrect .env configuration
- File permissions
- Database connection settings
