#!/bin/bash
# Fix PostgreSQL authentication for fieldops_user

echo "=== Resetting PostgreSQL User Password ==="
sudo -u postgres psql -c "ALTER USER fieldops_user WITH PASSWORD 'ChangeMe123!';"

echo ""
echo "=== Verifying PostgreSQL Connection ==="
cd /var/www/fieldops-pro
php artisan db:show

echo ""
echo "Done! Try running migrations again."
