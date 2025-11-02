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
        Schema::table('product_contents', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('product_id')->constrained('product_contents')->onDelete('cascade');
            $table->integer('duration_minutes')->nullable()->after('section_order'); // Estimated time to complete
            $table->text('description')->nullable()->after('title'); // Short description of the section
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_contents', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'duration_minutes', 'description']);
        });
    }
};
