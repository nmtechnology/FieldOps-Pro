# Security Testing & Hardening Guide

## 🔒 Automated Security Tests

Run the comprehensive security test suite:

```bash
php artisan test --filter SecurityTest
```

## 🛡️ Manual Penetration Testing Checklist

### 1. SQL Injection Testing

**Test Input Fields:**
- [ ] Product search: `/admin/products?search=`
- [ ] Order filtering: `/admin/orders?search=`
- [ ] User search: `/admin/users?search=`

**Common Payloads:**
```sql
' OR '1'='1
' OR 1=1--
'; DROP TABLE users--
' UNION SELECT NULL--
1' AND '1'='1
admin'--
```

**Tools:**
- SQLMap: `sqlmap -u "http://24.199.103.250/admin/products?search=test" --cookie="your-session-cookie"`
- Manual browser testing with URL encoding

### 2. Cross-Site Scripting (XSS)

**Test Input Fields:**
- [ ] Product name/description
- [ ] Contact form (name, subject, message)
- [ ] User profile fields
- [ ] Comments/feedback areas

**Common Payloads:**
```html
<script>alert('XSS')</script>
<img src=x onerror=alert('XSS')>
<svg/onload=alert('XSS')>
javascript:alert('XSS')
<iframe src="javascript:alert('XSS')">
```

**Testing:**
```bash
# Create product with XSS payload
curl -X POST http://24.199.103.250/admin/products \
  -H "Cookie: your-session" \
  -d "name=<script>alert('XSS')</script>&price=99"
```

### 3. CSRF (Cross-Site Request Forgery)

**Test:**
- [ ] Try submitting forms without CSRF token
- [ ] Use invalid CSRF tokens
- [ ] Replay old CSRF tokens

**Manual Test:**
```html
<!-- External site attempting CSRF -->
<form action="http://24.199.103.250/admin/products/1" method="POST">
  <input type="hidden" name="_method" value="DELETE">
  <input type="submit" value="Click me!">
</form>
```

### 4. Authentication & Authorization

**Test Cases:**
- [ ] Access admin routes without authentication
- [ ] Access admin routes as regular user
- [ ] Attempt privilege escalation via mass assignment
- [ ] Try session hijacking
- [ ] Test password reset token expiration
- [ ] Brute force login (should hit rate limit)

**Commands:**
```bash
# Test unauthorized admin access
curl -X GET http://24.199.103.250/admin/dashboard

# Test with regular user session
curl -X GET http://24.199.103.250/admin/dashboard \
  -H "Cookie: laravel_session=regular-user-session"
```

### 5. Path Traversal

**Test Input:**
```
../../../etc/passwd
..\..\..\..\windows\system32\config\sam
....//....//....//etc/passwd
```

**Test Routes:**
- [ ] File download endpoints
- [ ] Image/asset URLs
- [ ] Any file parameter

### 6. Command Injection

**Test Payloads:**
```bash
; ls -la
| cat /etc/passwd
`whoami`
$(whoami)
& dir
```

**Test In:**
- [ ] Email fields
- [ ] File upload names
- [ ] Any system command execution

### 7. File Upload Vulnerabilities

**Test Cases:**
- [ ] Upload PHP files disguised as images
- [ ] Upload files with double extensions (.jpg.php)
- [ ] Upload oversized files
- [ ] Upload files with malicious content

**Payloads:**
```bash
# Test file upload
curl -X POST http://24.199.103.250/admin/products \
  -F "image=@malicious.php.jpg"
```

### 8. API Security

**Test:**
- [ ] Mass assignment vulnerabilities
- [ ] Unprotected endpoints
- [ ] Rate limiting on API calls
- [ ] JWT token manipulation (if using)

## 🔧 Security Tools

### 1. OWASP ZAP (Zed Attack Proxy)

```bash
# Install
brew install --cask owasp-zap  # macOS
# or download from https://www.zaproxy.org/

# Run automated scan
zap-cli quick-scan http://24.199.103.250
```

### 2. Burp Suite Community

Download: https://portswigger.net/burp/communitydownload

**Usage:**
1. Configure browser to use Burp proxy (127.0.0.1:8080)
2. Browse your application
3. Analyze requests/responses
4. Use Intruder for automated testing

### 3. Nikto Web Scanner

```bash
# Install
brew install nikto  # macOS

# Scan
nikto -h http://24.199.103.250
```

### 4. SQLMap

```bash
# Install
pip install sqlmap

# Test for SQL injection
sqlmap -u "http://24.199.103.250/admin/products?search=test" \
  --cookie="laravel_session=your-session" \
  --level=5 \
  --risk=3
```

### 5. Nmap

```bash
# Scan open ports
nmap -sV 24.199.103.250

# Aggressive scan
nmap -A 24.199.103.250
```

## ✅ Security Hardening Checklist

### Application Level

- [x] CSRF protection enabled on all forms
- [x] SQL injection protection (using Eloquent ORM)
- [x] Mass assignment protection (fillable/guarded)
- [x] XSS protection (Blade auto-escaping)
- [ ] Rate limiting configured
- [ ] Security headers added
- [ ] Input validation on all forms
- [ ] File upload restrictions
- [ ] Secure session configuration

### Server Level

```bash
# SSH to server
ssh nmtechnology@24.199.103.250

# Check current security settings
# 1. Disable directory listing
sudo nano /etc/nginx/sites-available/default
# Add: autoindex off;

# 2. Hide Nginx version
sudo nano /etc/nginx/nginx.conf
# Add: server_tokens off;

# 3. Configure fail2ban
sudo apt install fail2ban -y
sudo systemctl enable fail2ban
sudo systemctl start fail2ban

# 4. Configure firewall
sudo ufw status
sudo ufw allow 22
sudo ufw allow 80
sudo ufw allow 443
sudo ufw enable

# 5. Keep system updated
sudo apt update && sudo apt upgrade -y

# 6. Set proper file permissions
cd /var/www/fieldops-pro
sudo chmod -R 755 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Environment Configuration

```bash
# Edit .env on server
sudo nano /var/www/fieldops-pro/.env

# Ensure these are set:
APP_ENV=production
APP_DEBUG=false
APP_KEY=<strong-random-key>
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
```

## 🚨 Enable Security Middleware

Add to `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \App\Http\Middleware\SecurityHeaders::class,
    ]);
})
```

## 📊 Continuous Monitoring

### Setup Laravel Logs

```bash
# On server
cd /var/www/fieldops-pro
php artisan log:clear

# Monitor in real-time
tail -f storage/logs/laravel.log
```

### Failed Login Attempts

Monitor: `storage/logs/laravel.log` for authentication failures

### Database Monitoring

```bash
# Check for suspicious queries
sudo tail -f /var/log/postgresql/postgresql-16-main.log | grep -i "error\|warning"
```

## 🔍 Vulnerability Scanning Schedule

- [ ] **Weekly**: Run automated security tests
- [ ] **Monthly**: Full penetration testing with OWASP ZAP
- [ ] **Quarterly**: Professional security audit
- [ ] **After each deployment**: Quick security scan

## 📝 Response Plan

If vulnerability found:

1. **Assess severity** (Critical/High/Medium/Low)
2. **Patch immediately** if critical
3. **Test the fix** thoroughly
4. **Deploy to production**
5. **Monitor logs** for exploitation attempts
6. **Document** the vulnerability and fix

## 🔗 Resources

- OWASP Top 10: https://owasp.org/www-project-top-ten/
- Laravel Security Best Practices: https://laravel.com/docs/security
- PHP Security Cheat Sheet: https://cheatsheetseries.owasp.org/cheatsheets/PHP_Configuration_Cheat_Sheet.html
