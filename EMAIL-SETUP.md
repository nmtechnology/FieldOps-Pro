# Email Configuration for FieldEngineer Pro
# Add these to your .env file on the server

# Mail Settings
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@fieldengineerpro.com"
MAIL_FROM_NAME="${APP_NAME}"

# Admin and Support Emails
MAIL_ADMIN_EMAIL="admin@fieldengineerpro.com"
MAIL_SUPPORT_EMAIL="support@fieldengineerpro.com"

# Instructions:
# 1. If using Gmail:
#    - Enable 2FA on your Google account
#    - Create an App Password: https://myaccount.google.com/apppasswords
#    - Use the app password (not your regular password) for MAIL_PASSWORD
#
# 2. If using a custom domain email (recommended):
#    - Get SMTP settings from your email provider
#    - Update MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD
#    - Common providers:
#      * Gmail: smtp.gmail.com:587
#      * Outlook/Office365: smtp.office365.com:587
#      * SendGrid: smtp.sendgrid.net:587
#      * Mailgun: smtp.mailgun.org:587
#
# 3. For production, consider using a transactional email service:
#    - SendGrid (free tier: 100 emails/day)
#    - Mailgun (free tier: 5,000 emails/month)
#    - Amazon SES (very cheap, $0.10 per 1000 emails)
#    - Postmark (100 emails/month free)
