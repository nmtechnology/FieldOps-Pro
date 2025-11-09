#!/bin/bash
# Deploy email system for FieldEngineer Pro

echo "=== Deploying Email System ==="

# Extract build
cd /var/www/fieldops-pro/public
rm -rf build
tar xzf ~/email_deploy/build.tar.gz
echo "✓ Frontend assets deployed"

# Copy PHP files
cp ~/email_deploy/OrderPlacedAdmin.php /var/www/fieldops-pro/app/Mail/
cp ~/email_deploy/PurchaseConfirmation.php /var/www/fieldops-pro/app/Mail/
cp ~/email_deploy/SupportRequest.php /var/www/fieldops-pro/app/Mail/
cp ~/email_deploy/StripeWebhookController.php /var/www/fieldops-pro/app/Http/Controllers/
cp ~/email_deploy/ContactController.php /var/www/fieldops-pro/app/Http/Controllers/
cp ~/email_deploy/web.php /var/www/fieldops-pro/routes/
echo "✓ Backend files deployed"

# Copy email templates
mkdir -p /var/www/fieldops-pro/resources/views/emails
cp ~/email_deploy/order-placed-admin.blade.php /var/www/fieldops-pro/resources/views/emails/
cp ~/email_deploy/purchase-confirmation.blade.php /var/www/fieldops-pro/resources/views/emails/
cp ~/email_deploy/support-request.blade.php /var/www/fieldops-pro/resources/views/emails/
echo "✓ Email templates deployed"

# Clear caches
cd /var/www/fieldops-pro
php artisan route:clear
php artisan cache:clear
php artisan config:clear
php artisan view:clear
echo "✓ Caches cleared"

echo ""
echo "=== Email System Deployed Successfully! ==="
echo ""
echo "📧 NEXT STEPS:"
echo "1. Configure email settings in .env (see ~/email_deploy/EMAIL-SETUP.md)"
echo "2. Add these lines to /var/www/fieldops-pro/.env:"
echo ""
echo "   MAIL_MAILER=smtp"
echo "   MAIL_HOST=smtp.gmail.com"
echo "   MAIL_PORT=587"
echo "   MAIL_USERNAME=your-email@gmail.com"
echo "   MAIL_PASSWORD=your-app-password"
echo "   MAIL_ENCRYPTION=tls"
echo "   MAIL_FROM_ADDRESS=\"noreply@fieldengineerpro.com\""
echo "   MAIL_FROM_NAME=\"\${APP_NAME}\""
echo "   MAIL_ADMIN_EMAIL=\"admin@fieldengineerpro.com\""
echo "   MAIL_SUPPORT_EMAIL=\"support@fieldengineerpro.com\""
echo ""
echo "3. Test the contact form at: http://24.199.103.250/contact"
echo "4. Make a test purchase to verify order emails"
echo ""
