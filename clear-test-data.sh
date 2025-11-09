#!/bin/bash
# Clear test data from production database

cd /var/www/fieldops-pro

echo "=== Clearing test data from production database ==="

# Use Laravel to clear the data safely
php artisan tinker << 'EOF'
// Delete all orders
\App\Models\Order::truncate();
echo "✓ Cleared all orders\n";

// Delete all payments
\App\Models\Payment::truncate();
echo "✓ Cleared all payments\n";

// Delete test users (keep only admin)
\App\Models\User::where('email', '!=', 'admin@fieldengineer.pro')->delete();
echo "✓ Deleted test users (kept admin)\n";

echo "\n=== Production database is now clean and ready for live orders ===\n";
exit
EOF

echo ""
echo "Done! Your dashboard is ready for live orders."
