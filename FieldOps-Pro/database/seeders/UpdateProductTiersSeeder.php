<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class UpdateProductTiersSeeder extends Seeder
{
    /**
     * Run the database seeds to update product tiers.
     */
    public function run(): void
    {
        // FieldOps Scout tier - one-time fee
        $scoutProduct = Product::updateOrCreate(
            ['name' => 'FieldOps Scout'],
            [
                'description' => 'Entry-level tier for beginners looking to set up their profile and gain access to the low voltage contracting market. Learn the essentials of field engineering platforms and how to present yourself professionally.',
                'type' => 'info',
                'price' => 22.99,
                'active' => true,
                'content_sections' => [
                    'Profile Setup Guide',
                    'Market Access Fundamentals',
                    'Platform Navigation Tutorial',
                    'Getting Your First Job',
                ]
            ]
        );
        
        $this->command->info("Updated/Created FieldOps Scout tier: $22.99 one-time fee");
        
        // FieldOps Pro tier - monthly subscription
        $proProduct = Product::updateOrCreate(
            ['name' => 'FieldOps Pro'],
            [
                'description' => 'Mid-tier subscription for contractors seeking to establish a consistent income stream. Learn advanced bidding techniques, develop competitive pricing strategies, and manage client relationships effectively.',
                'type' => 'info',
                'price' => 33.99,
                'active' => true,
                'content_sections' => [
                    'Advanced Bidding Strategies',
                    'Competitive Rate Setting',
                    'Client Management Systems',
                    'Monthly Income Planning',
                    'Field Engineering Best Practices',
                    'Technical Specifications Guide',
                ]
            ]
        );
        
        $this->command->info("Updated/Created FieldOps Pro tier: $33.99/month");
        
        // FieldOps Elite tier - premium monthly subscription
        $eliteProduct = Product::updateOrCreate(
            ['name' => 'FieldOps Elite'],
            [
                'description' => 'Premium tier for serious field engineers looking to maximize earnings and create a sustainable business. Get personal insights on scaling your operations, handling multiple contracts, and building a reputation that commands top rates.',
                'type' => 'info',
                'price' => 44.99,
                'active' => true,
                'content_sections' => [
                    'Premium Bid Templates',
                    'Rate Optimization Framework',
                    'Enterprise Client Acquisition',
                    'Scaling Your Field Engineering Business',
                    'Advanced Technical Specializations',
                    'Multiple Contract Management',
                    'VIP Support and Mentoring',
                    'Business Analysis Tools',
                ]
            ]
        );
        
        $this->command->info("Updated/Created FieldOps Elite tier: $44.99/month");
        
        // Make FieldOps Pro the featured product
        if ($proProduct) {
            $proProduct->update([
                'image_path' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1269&q=80',
            ]);
        }
    }
}