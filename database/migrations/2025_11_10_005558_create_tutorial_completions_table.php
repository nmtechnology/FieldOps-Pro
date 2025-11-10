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
        Schema::create('tutorial_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->json('quiz_answers')->nullable(); // Store quiz responses for verification
            $table->integer('score')->nullable(); // Percentage score
            $table->timestamp('completed_at');
            $table->timestamps();
            
            $table->unique(['user_id', 'product_id']); // User can only complete tutorial once per product
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutorial_completions');
    }
};
