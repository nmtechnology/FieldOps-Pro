# Visitor Tracking & Analytics System

## Overview
Comprehensive visitor tracking system that captures detailed information about visitors when they solve the verification puzzle and sends weekly analytics reports.

## Features

### 1. **Real-Time Visitor Tracking**
When visitors land on the site and solve the verification puzzle, the system captures:
- **IP Address** - Real IP with proxy detection
- **Geolocation** - Country, region, city, coordinates, timezone
- **ISP Information** - Internet service provider details
- **Device Details** - Type (desktop/mobile/tablet), browser, version, OS
- **Referral Data** - Source URL and domain they came from
- **Landing Page** - First page visited
- **Session Information** - Unique session tracking

### 2. **Instant Email Notifications**
Every time a visitor verifies, admins receive an email with:
- Complete visitor profile
- Location on map (coordinates)
- Device and browser information
- Referrer source
- Timestamp

**Recipients:**
- purchases@fieldengineerpro.com
- patrick@nmtechnology.us

### 3. **Weekly Analytics Reports**
Every Monday at 9 AM, a comprehensive report is sent containing:
- Total visitors vs verified visitors
- Verification rate percentage
- Top 10 countries
- Top 10 referrer domains
- Device breakdown (desktop/mobile/tablet)
- Browser and OS statistics
- Hourly distribution chart
- Last 20 verified visitors with details

## Database Structure

### `visitor_logs` Table
```sql
- id
- ip_address (IPv6 compatible)
- country, country_code, region, city
- latitude, longitude, timezone
- isp (Internet Service Provider)
- referrer_url, referrer_domain
- landing_page
- user_agent
- device_type, browser, browser_version
- platform, platform_version
- session_id
- verified (boolean)
- verified_at (timestamp)
- created_at, updated_at
```

## Configuration

### Email Recipients
Edit `.env` file:
```env
# Purchase & visitor notifications
MAIL_ADMIN_EMAILS=purchases@fieldengineerpro.com,patrick@nmtechnology.us

# Support requests  
MAIL_SUPPORT_EMAILS=support@fieldengineerpro.com,patrick@nmtechnology.us
```

Or configure in `config/mail.php`:
```php
'admin_emails' => ['purchases@fieldengineerpro.com', 'patrick@nmtechnology.us'],
'support_emails' => ['support@fieldengineerpro.com', 'patrick@nmtechnology.us'],
```

### Schedule Configuration
Weekly reports scheduled in `routes/console.php`:
```php
Schedule::command('visitors:weekly-report')
    ->weeklyOn(1, '9:00')  // Monday at 9 AM
    ->timezone('America/New_York');
```

## Manual Commands

### Send Weekly Report Now
```bash
php artisan visitors:weekly-report
```

### Test Visitor Tracking
Visit the site and solve the puzzle. Check:
1. Immediate email notification
2. Database entry: `select * from visitor_logs order by id desc limit 1;`
3. Log files: `storage/logs/laravel.log`

### View Scheduled Tasks
```bash
php artisan schedule:list
```

## Geolocation API

Uses **ip-api.com** (free tier):
- No API key required
- 45 requests/minute limit
- Provides: country, city, lat/lon, ISP, timezone
- Fallback: Gracefully handles localhost and API failures

## Cron Setup (Production)

The Laravel scheduler requires a single cron entry:

```bash
* * * * * cd /var/www/fieldops-pro && php artisan schedule:run >> /dev/null 2>&1
```

This will automatically run the weekly report every Monday at 9 AM.

### Add to Crontab
```bash
# On production server
sudo crontab -e

# Add this line:
* * * * * cd /var/www/fieldops-pro && php artisan schedule:run >> /dev/null 2>&1
```

## Files Created/Modified

### New Files
- `database/migrations/2025_11_09_052420_create_visitor_logs_table.php`
- `app/Models/VisitorLog.php`
- `app/Services/VisitorTrackingService.php`
- `app/Mail/VisitorVerified.php`
- `app/Mail/WeeklyVisitorReport.php`
- `app/Console/Commands/SendWeeklyVisitorReport.php`
- `resources/views/emails/visitor-verified.blade.php`
- `resources/views/emails/weekly-visitor-report.blade.php`

### Modified Files
- `routes/web.php` - Added tracking on bot-check and verify routes
- `routes/console.php` - Added weekly report schedule
- `config/mail.php` - Added admin_emails and support_emails arrays
- `composer.json` - Added jenssegers/agent package

## Dependencies

### New Package
```bash
composer require jenssegers/agent
```

This package provides User-Agent parsing for device, browser, and OS detection.

## Privacy & Compliance

- IP addresses are stored for analytics purposes
- Geolocation data is approximate (city-level)
- No personally identifiable information (PII) is collected
- Session tracking is anonymous
- Consider adding privacy policy disclosure

## Troubleshooting

### Emails Not Sending
Check:
1. `.env` mail configuration (MAIL_MAILER, MAIL_HOST, etc.)
2. Run `php artisan config:clear`
3. Check logs: `tail -f storage/logs/laravel.log`

### Geolocation Not Working
- Check if `allow_url_fopen` is enabled
- Verify HTTP requests aren't blocked
- Check rate limits (45/min max)

### Weekly Report Not Sending
1. Verify cron is running: `sudo systemctl status cron`
2. Check crontab: `sudo crontab -l`
3. Test manually: `php artisan visitors:weekly-report`
4. Check schedule: `php artisan schedule:list`

## Support

For questions or issues:
- Email: patrick@nmtechnology.us
- Check logs: `storage/logs/laravel.log`
