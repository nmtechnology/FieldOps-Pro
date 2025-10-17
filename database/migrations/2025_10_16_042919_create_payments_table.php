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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->string('payment_method'); // 'card', 'ach'
            $table->string('payment_id')->nullable(); // Stripe payment ID
            $table->string('status');  // 'pending', 'completed', 'refunded', 'failed'
            $table->decimal('amount', 8, 2);
            $table->string('currency')->default('USD');
            $table->json('payment_details')->nullable(); // Store payment details
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
