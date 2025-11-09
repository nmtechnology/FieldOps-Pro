# Professional Email & Support System - Complete Setup Guide

## 🎉 What's Been Built

Your FieldEngineer Pro now has a complete professional support system:

### 1. **Admin Order Notifications**
- Get emailed instantly when someone makes a purchase
- Email goes to: `admin@fieldengineerpro.com`
- Includes: Customer info, product purchased, order total, discount applied
- Direct link to view order in admin panel

### 2. **Customer Purchase Confirmations**
- Customers get a beautiful receipt email
- Includes: Order summary, direct link to access their content
- Professional branding matching your site

### 3. **Support Contact Form**
- Professional contact page at: `/contact`
- Form fields: Name, Email, Subject, Message
- Emails go to: `support@fieldengineerpro.com`
- Reply-to automatically set to customer's email

### 4. **Footer Integration**
- "Contact Support" link added to homepage footer
- Accessible from all public pages

---

## 📋 Deployment Instructions

**On your server, run:**

```bash
cd ~
bash deploy-email-system.sh
```

This will:
- Deploy all frontend assets
- Install email notification system
- Set up contact form
- Clear all caches

---

## 📧 Email Configuration (CRITICAL STEP)

You MUST configure email in your `.env` file for this to work.

**Option 1: Using Gmail (Quickest for Testing)**

1. Enable 2-Factor Authentication on your Google account
2. Generate an App Password: https://myaccount.google.com/apppasswords
3. Add to `/var/www/fieldops-pro/.env`:

```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@fieldengineerpro.com"
MAIL_FROM_NAME="FieldEngineer Pro"
MAIL_ADMIN_EMAIL="admin@fieldengineerpro.com"
MAIL_SUPPORT_EMAIL="support@fieldengineerpro.com"
```

**Option 2: Using a Professional Email Service (Recommended for Production)**

Choose one:

**SendGrid** (100 emails/day free):
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
```

**Mailgun** (5,000 emails/month free):
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=your-mailgun-username
MAIL_PASSWORD=your-mailgun-password
MAIL_ENCRYPTION=tls
```

**Amazon SES** ($0.10 per 1000 emails):
```bash
MAIL_MAILER=smtp
MAIL_HOST=email-smtp.us-east-1.amazonaws.com
MAIL_PORT=587
MAIL_USERNAME=your-ses-smtp-username
MAIL_PASSWORD=your-ses-smtp-password
MAIL_ENCRYPTION=tls
```

---

## ✅ Testing Your Setup

### Test 1: Contact Form
1. Visit: `http://24.199.103.250/contact`
2. Fill out the form
3. Click "Send Message"
4. Check support@fieldengineerpro.com for the email

### Test 2: Order Notification
1. Make a test purchase on your site
2. Complete the Stripe payment
3. Check admin@fieldengineerpro.com for admin notification
4. Check customer email for purchase confirmation

### Test 3: Admin Panel
1. Log into admin dashboard
2. You should see the order appear
3. Stats should update in real-time

---

## 🔧 Troubleshooting

**Emails not sending?**
1. Check `/var/www/fieldops-pro/storage/logs/laravel.log` for errors
2. Verify `.env` settings are correct
3. Test SMTP connection:
   ```bash
   cd /var/www/fieldops-pro
   php artisan tinker
   >>> Mail::raw('Test email', function($msg) { $msg->to('your-email@gmail.com')->subject('Test'); });
   ```

**Contact form showing error?**
1. Clear caches: `php artisan cache:clear`
2. Check route is registered: `php artisan route:list | grep contact`
3. Check controller exists: `ls -la app/Http/Controllers/ContactController.php`

**Order emails not triggering?**
1. Check Stripe webhooks are configured
2. Verify webhook secret in `.env`: `STRIPE_WEBHOOK_SECRET`
3. Check webhook logs in Stripe dashboard

---

## 📊 Email Templates

All email templates are in:
- `/var/www/fieldops-pro/resources/views/emails/`

You can customize:
- **order-placed-admin.blade.php** - Admin order notification
- **purchase-confirmation.blade.php** - Customer receipt
- **support-request.blade.php** - Support form email

---

## 🎯 What Customers See

**After Purchase:**
1. Checkout page → Complete payment
2. Immediate redirect to thank you page
3. Email arrives within seconds with:
   - Order confirmation
   - Order number
   - Product access link
   - Your support contact info

**When They Need Help:**
1. Click "Contact Support" in footer
2. Fill out form with their question
3. Get confirmation message
4. You receive email and can reply directly

---

## 💡 Pro Tips

1. **Set up email forwarding** so admin@ and support@ both go to your main email
2. **Use Gmail filters** to automatically label order notifications
3. **Enable desktop notifications** for support emails to respond quickly
4. **Check spam folder** first time to whitelist the emails
5. **Consider upgrading** to a paid email service once you hit 100+ orders/month

---

## 🚀 Next Steps

1. Configure email settings in `.env`
2. Test contact form
3. Make a test purchase
4. Set up email forwarding/filters
5. Add your phone number or additional contact methods to Contact page if desired

---

## 📧 Your Email Addresses

- **admin@fieldengineerpro.com** - Order notifications
- **support@fieldengineerpro.com** - Customer support
- **noreply@fieldengineerpro.com** - Automated emails from your site

Make sure these are set up with your domain provider or email service!

---

Need help? The system is fully deployed and ready. Just configure the `.env` file and test! 🎉
