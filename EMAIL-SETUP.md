# Email Configuration for FieldEngineer Pro

## Current Setup: Private Email SMTP

### Production .env Configuration

```env
# Mail Settings - Private Email
MAIL_MAILER=smtp
MAIL_HOST=mail.privateemail.com
MAIL_PORT=587
MAIL_USERNAME=patrick@nmtechnology.us
MAIL_PASSWORD=YOUR_PRIVATE_EMAIL_PASSWORD
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@fieldengineerpro.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Alternative Configuration (SSL)

If TLS on port 587 doesn't work, try SSL on port 465:

```env
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
```

### Private Email Server Details

**SMTP (Outgoing Mail):**
- Server: mail.privateemail.com
- Port: 587 (TLS) or 465 (SSL)
- Authentication: Required
- Username: Full email address (patrick@nmtechnology.us)
- Password: Your Private Email account password
- SPA: Disabled

**IMAP (Incoming Mail - for reference):**
- Server: mail.privateemail.com
- Port: 993 (SSL) or 143 (TLS)

**POP3 (Alternative Incoming):**
- Server: mail.privateemail.com
- Port: 995 (SSL)

### Setup Instructions

1. **Update production .env:**
   ```bash
   ssh root@24.199.103.250
   cd /var/www/fieldops-pro
   nano .env
   ```

2. **Add/Update these lines:**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=mail.privateemail.com
   MAIL_PORT=587
   MAIL_USERNAME=patrick@nmtechnology.us
   MAIL_PASSWORD=your_actual_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="noreply@fieldengineerpro.com"
   MAIL_FROM_NAME="FieldEngineer Pro"
   ```

3. **Clear and cache config:**
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

4. **Test email:**
   ```bash
   php artisan tinker
   Mail::raw('Test email', function($m) { 
       $m->to('patrick@nmtechnology.us')->subject('Test'); 
   });
   ```

### Email Addresses in Use

**Admin/Support (in config/mail.php):**
- purchases@fieldengineerpro.com
- patrick@nmtechnology.us

**From Address:**
- Production: noreply@fieldengineerpro.com
- Development: patrick@nmtechnology.us

### Troubleshooting

**Check logs:**
```bash
tail -f /var/www/fieldops-pro/storage/logs/laravel.log
```

**Test SMTP connection:**
```bash
telnet mail.privateemail.com 587
```

**Common Issues:**
- Wrong port: Try 465 with SSL instead of 587 with TLS
- Firewall: Ensure ports 587/465 are open
- Password: Use exact password from Private Email
- Username: Must be full email address

### Future: Domain Email Migration

When purchasing email for fieldengineerpro.com domain:

1. Create these addresses:
   - noreply@fieldengineerpro.com
   - support@fieldengineerpro.com
   - purchases@fieldengineerpro.com

2. Get SMTP credentials from provider

3. Update .env with new credentials

4. Update config/mail.php email arrays
