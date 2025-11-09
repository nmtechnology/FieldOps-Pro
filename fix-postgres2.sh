#!/bin/bash
# Check and fix PostgreSQL setup

echo "=== Checking .env file database settings ==="
grep "DB_" /var/www/fieldops-pro/.env

echo ""
echo "=== Dropping and recreating user ==="
sudo -u postgres psql << EOF
DROP USER IF EXISTS fieldops_user;
CREATE USER fieldops_user WITH PASSWORD 'ChangeMe123!';
ALTER USER fieldops_user CREATEDB;
GRANT ALL PRIVILEGES ON DATABASE fieldops_pro TO fieldops_user;
EOF

echo ""
echo "=== Testing connection manually ==="
PGPASSWORD='ChangeMe123!' psql -h 127.0.0.1 -U fieldops_user -d fieldops_pro -c "SELECT version();"

echo ""
echo "Done! Try migrations again."
