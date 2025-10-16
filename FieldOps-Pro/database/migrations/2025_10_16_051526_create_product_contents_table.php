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
        Schema::create('product_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('section_type'); // 'introduction', 'chapter', 'bonus', 'conclusion', etc.
            $table->integer('section_order'); // To control the display order
            $table->text('content'); // For text content
            $table->json('media')->nullable(); // For images, videos, or other media
            $table->json('downloads')->nullable(); // For downloadable files
            $table->boolean('is_premium')->default(true); // To control what content is free vs premium
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_contents');
    }
};
