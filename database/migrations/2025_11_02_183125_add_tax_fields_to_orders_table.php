<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('buyer_state', 2)->nullable()->after('email'); // US state code (e.g., 'CA', 'NY')
            $table->decimal('subtotal', 10, 2)->nullable()->after('total_amount'); // Amount before tax
            $table->decimal('tax_rate', 5, 4)->default(0)->after('subtotal'); // Tax rate as decimal (e.g., 0.0825 for 8.25%)
            $table->decimal('tax_amount', 10, 2)->default(0)->after('tax_rate'); // Calculated tax amount
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['buyer_state', 'subtotal', 'tax_rate', 'tax_amount']);
        });
    }
};
