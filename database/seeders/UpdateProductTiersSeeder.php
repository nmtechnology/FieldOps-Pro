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
            ['name' => 'Field Operations Guide - Complete Side Hustle Training'],
            [
                'description' => 'Your complete roadmap to launching a profitable field tech side hustle. This comprehensive digital guide provides lifetime access to proven strategies for establishing your skills, building your toolkit, defining your territory, setting up on work platforms, and maintaining a 5-star reputation. Everything you need to start earning $2000-5000+ monthly in your spare time.',
                'type' => 'info',
                'price' => 75.99,
                'active' => true,
                'content_sections' => [
                    'Section 1: Skills Assessment & Development - Identify and establish your expertise in computer PC support, smart home technology, and low voltage troubleshooting and service',
                    'Section 2: Essential Tools & Equipment - Specially compiled tool list with purchasing guides, detailed explanations of each tool\'s use, and field troubleshooting applications',
                    'Section 3: Territory Establishment - Define your service area, learn what types of work to accept and avoid, and establish your business boundaries',
                    'Section 4: Platform Setup & Activation - Complete walkthrough of work platforms, profile optimization, insurance requirements, pay rate establishment, and account activation',
                    'Section 5: Reputation Management - Master the best practices for maintaining a strong profile and achieving the highest possible ratings to maximize your earning potential',
                ]
            ]
        );
        
        $this->command->info("Updated/Created Field Operations Guide: $75.99 one-time fee (lifetime access)");
        
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