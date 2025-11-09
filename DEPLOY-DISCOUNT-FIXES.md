# Deploy Discount System Fixes

## What Was Fixed
The discount creation form was not working due to field naming mismatches between:
- Database columns: `active`, `value`, `valid_from`, `valid_until`
- Frontend forms: `is_active`, `value`, `valid_from`, `valid_until`
- Controller validation: Previously expected wrong field names

## Changes Made (Already Committed & Pushed)
✅ Commit: `22cefe6 "Refactor discount fields and update email setup docs"`

1. **Controller** (`app/Http/Controllers/Admin/DiscountController.php`):
   - Fixed validation to use correct field names
   - Added `is_active` → `active` mapping
   - Made `description` optional

2. **Frontend** (`resources/js/Pages/Admin/Discounts/Index.vue`):
   - Fixed all field names to match database schema
   - Added missing fields (`valid_from`, `max_uses`)
   - Corrected form bindings

## Deployment Steps

### SSH into Server:
```bash
ssh root@24.199.103.250
```

### Pull Latest Code:
```bash
cd /var/www/fieldops-pro
git pull origin main
```

### Install Dependencies (if any changed):
```bash
composer install --no-dev --optimize-autoloader
npm install
```

### Build Frontend Assets:
```bash
npm run build
```

### Clear Caches:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize
```

### Set Permissions:
```bash
chown -R www-data:www-data /var/www/fieldops-pro
chmod -R 755 /var/www/fieldops-pro
chmod -R 775 /var/www/fieldops-pro/storage
chmod -R 775 /var/www/fieldops-pro/bootstrap/cache
```

### Restart Services:
```bash
systemctl restart nginx
systemctl restart php8.3-fpm
php artisan queue:restart
```

## Verify Deployment

1. Visit admin panel: https://fieldengineerpro.com/admin/discounts
2. Click "Add New Discount"
3. Fill in the form:
   - Code: `LAUNCH2024`
   - Type: Percentage
   - Value: `20`
   - Active: Checked
   - Valid Until: Set a future date
4. Click "Create Discount"
5. Should redirect back to list with success message
6. Visit homepage: https://fieldengineerpro.com
7. Should see discounted price with strikethrough on original price

## Troubleshooting

**If discount still doesn't save:**
```bash
tail -f /var/www/fieldops-pro/storage/logs/laravel.log
```

**Check JavaScript console in browser:**
- Open DevTools (F12)
- Look for errors when clicking "Create Discount"

**Verify database schema:**
```bash
php artisan tinker
Schema::getColumnListing('discounts');
```

Expected columns: `id`, `code`, `type`, `value`, `max_uses`, `used`, `active`, `valid_from`, `valid_until`, `description`, `created_at`, `updated_at`
