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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_subscription')->default(false)->after('active');
            $table->string('stripe_price_id')->nullable()->after('is_subscription');
            $table->integer('billing_cycle_days')->default(30)->after('stripe_price_id');
            $table->boolean('allow_reactivation')->default(true)->after('billing_cycle_days');
            $table->integer('grace_period_days')->default(0)->after('allow_reactivation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'is_subscription',
                'stripe_price_id',
                'billing_cycle_days',
                'allow_reactivation',
                'grace_period_days'
            ]);
        });
    }
};
