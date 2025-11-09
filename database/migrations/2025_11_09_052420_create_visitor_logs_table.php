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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45); // IPv6 compatible
            $table->string('country')->nullable();
            $table->string('country_code', 2)->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('timezone')->nullable();
            $table->string('isp')->nullable();
            $table->string('referrer_url', 500)->nullable();
            $table->string('referrer_domain')->nullable();
            $table->string('landing_page', 500)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('device_type')->nullable(); // desktop, mobile, tablet
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('platform')->nullable(); // OS
            $table->string('platform_version')->nullable();
            $table->string('session_id')->nullable();
            $table->boolean('verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            
            // Indexes for reporting
            $table->index('ip_address');
            $table->index('verified');
            $table->index('created_at');
            $table->index('country_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
