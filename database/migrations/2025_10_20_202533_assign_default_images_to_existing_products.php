<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all products that don't have images assigned
        $productsWithoutImages = Product::whereNull('image_path')
            ->orWhere('image_path', '')
            ->get();

        foreach ($productsWithoutImages as $product) {
            $product->assignDefaultImageIfNeeded();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get available default images to identify which ones to revert
        $defaultImages = Product::getAvailableDefaultImages();
        $defaultImageUrls = collect($defaultImages)->map(fn($image) => asset("img/{$image}"));
        
        // Also include the artificial-book case
        $defaultImageUrls->push('artificial-book');
        
        // Revert products that have default images back to null
        Product::whereIn('image_path', $defaultImageUrls)->update(['image_path' => null]);
    }
};
