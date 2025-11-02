# DigitalOcean App Platform Deployment Guide

## 🚀 Quick Deploy to DigitalOcean

### Prerequisites
- DigitalOcean account
- GitHub repository: nmtechnology/FieldOps-Pro
- Domain: fieldengineerpro.com pointed to DigitalOcean nameservers

### Step 1: Push to GitHub
```bash
cd /Users/nmtechnology/Documents/Dev/FieldOps-Pro
git add .
git commit -m "Prepare for DigitalOcean deployment"
git push origin main
```

### Step 2: Create App on DigitalOcean

1. Go to https://cloud.digitalocean.com/apps
2. Click **"Create App"**
3. Select **"GitHub"** as source
4. Authorize DigitalOcean to access your GitHub
5. Select repository: **nmtechnology/FieldOps-Pro**
6. Select branch: **main**
7. Click **"Next"**

### Step 3: Configure App (Auto-detected from .do/app.yaml)

DigitalOcean will automatically detect the configuration. Review:

**Resources:**
- ✅ Web Service (Laravel app)
- ✅ Worker Service (Queue processor)
- ✅ MySQL Database

**Estimated Cost:** ~$17/month
- Web: $5/month (Basic)
- Worker: $5/month (Basic)
- Database: $7/month (Basic)

### Step 4: Set Environment Variables

Click **"Edit"** on the Web service and add these secrets:

**Required:**
```
APP_KEY=base64:YOUR_APP_KEY_HERE
```

Get your APP_KEY by running locally:
```bash
php artisan key:generate --show
```

**Stripe (if using):**
```
STRIPE_KEY=pk_live_your_key_here
STRIPE_SECRET=sk_live_your_secret_here
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here
```

**Coinbase Commerce (if using):**
```
COINBASE_COMMERCE_API_KEY=your_api_key_here
COINBASE_COMMERCE_WEBHOOK_SECRET=your_webhook_secret_here
```

### Step 5: Configure Domain

1. In App settings, go to **"Domains"**
2. Add custom domain: **fieldengineerpro.com**
3. DigitalOcean will provide DNS records

**Update your domain DNS:**
- Add CNAME record: `@` → `your-app.ondigitalocean.app`
- Add CNAME record: `www` → `your-app.ondigitalocean.app`

Or use DigitalOcean nameservers:
- ns1.digitalocean.com
- ns2.digitalocean.com
- ns3.digitalocean.com

### Step 6: Deploy

1. Click **"Create Resources"**
2. Wait 5-10 minutes for deployment
3. App will be available at: https://fieldengineerpro.com

## 📋 Post-Deployment Tasks

### 1. Run Database Seeders (Optional)
```bash
# From DigitalOcean Console or doctl CLI
doctl apps logs <app-id> web
php artisan db:seed --class=AdminSeeder
```

### 2. Setup Webhooks

**Stripe Webhook:**
- URL: `https://fieldengineerpro.com/stripe/webhook`
- Events: `charge.succeeded`, `charge.failed`, `payment_intent.succeeded`

**Coinbase Commerce Webhook:**
- URL: `https://fieldengineerpro.com/coinbase/webhook`
- Events: All payment events

### 3. Test Payment Methods
- Test Stripe checkout
- Test Coinbase Bitcoin checkout
- Verify webhook deliveries

### 4. Monitor Application
- Check logs: `doctl apps logs <app-id> web`
- View metrics in DigitalOcean dashboard
- Setup uptime monitoring

## 🔄 Automatic Deployments

Any push to `main` branch will automatically trigger deployment:
```bash
git add .
git commit -m "Update feature"
git push origin main
# App automatically rebuilds and redeploys
```

## 🐛 Troubleshooting

### Logs
View real-time logs:
```bash
doctl apps logs <app-id> web --follow
```

### Clear Cache
If you make config changes:
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### Database Issues
Check database connection:
```bash
php artisan migrate:status
```

### Queue Not Processing
Check worker logs:
```bash
doctl apps logs <app-id> worker
```

## 💰 Cost Optimization

**Current Setup:** ~$17/month

**To reduce costs:**
- Start without worker ($12/month)
- Use smaller database ($5/month)
- Total minimum: ~$10/month

**To scale up:**
- Increase instance sizes
- Add more workers
- Enable autoscaling

## 🔐 Security Checklist

- ✅ APP_DEBUG=false in production
- ✅ Strong APP_KEY generated
- ✅ HTTPS enabled (automatic)
- ✅ Database passwords are secrets
- ✅ API keys stored as secrets
- ✅ CSRF protection enabled
- ✅ Rate limiting configured

## 📞 Support

DigitalOcean Documentation:
- https://docs.digitalocean.com/products/app-platform/

Laravel Deployment:
- https://laravel.com/docs/deployment

Need help? Check logs first, then DigitalOcean support.
