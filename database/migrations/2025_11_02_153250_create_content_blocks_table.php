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
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_content_id')->constrained()->onDelete('cascade');
            $table->string('block_type'); // 'text', 'image', 'video', 'heading'
            $table->integer('block_order')->default(0);
            $table->text('content')->nullable(); // For text content and headings
            $table->string('media_type')->nullable(); // 'webp', 'mp4', 'webm', 'jpg', 'png'
            $table->string('media_path')->nullable(); // Path to uploaded media file
            $table->string('media_url')->nullable(); // External URL for media
            $table->text('caption')->nullable(); // Caption for images/videos
            $table->json('metadata')->nullable(); // Additional metadata (dimensions, duration, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
    }
};
