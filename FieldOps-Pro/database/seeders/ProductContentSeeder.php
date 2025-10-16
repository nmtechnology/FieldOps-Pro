<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class ProductContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find or create an info product
        $product = \App\Models\Product::where('type', 'info')->first();
        
        if (!$product) {
            // Create a sample info product if none exists
            $product = \App\Models\Product::create([
                'name' => 'Field Operations Guide',
                'description' => 'A comprehensive guide to field operations management including best practices, templates, and resources.',
                'type' => 'info',
                'price' => 29.99,
                'active' => true
            ]);
            
            $this->command->info("Created info product: {$product->name}");
        }
        
        // Run the command to seed content for this product
        $this->command->info("Seeding content for product ID: {$product->id}");
        Artisan::call('app:seed-sample-product-content', [
            'product_id' => $product->id
        ], $this->command->getOutput());
    }
}