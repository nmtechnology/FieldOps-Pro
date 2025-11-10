<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductContent;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerProductController extends Controller
{
    /**
     * Display the product as a customer would see it after purchase.
     * Admins can access this directly, regular users need to own the product.
     */
    public function show(Product $product)
    {
        $user = auth()->user();
        $isAdmin = $user && $user->is_admin;
        
        // Check if user has access to this product
        if (!$isAdmin) {
            // Check if the user has purchased this product
            $hasPurchased = $user && $user->orders()
                ->where('status', 'completed')
                ->where('product_id', $product->id)
                ->exists();
                
            if (!$hasPurchased) {
                abort(403, 'You must purchase this product to access its content.');
            }
        }
        
        // Load product with its published content
        $product->load(['contents' => function ($query) {
            $query->where('is_published', true)->orderBy('section_order');
        }]);
        
        return Inertia::render('Customer/Product/Show', [
            'product' => $product,
            'isAdminPreview' => $isAdmin,
            'userHasPurchased' => $isAdmin || ($user && $user->orders()
                ->where('status', 'completed')
                ->where('product_id', $product->id)
                ->exists())
        ]);
    }
    
    /**
     * Display a specific content section
     */
    public function showContent(Product $product, ProductContent $content)
    {
        $user = auth()->user();
        $isAdmin = $user && $user->is_admin;
        
        // Verify the content belongs to this product
        if ($content->product_id !== $product->id) {
            abort(404);
        }
        
        // Check if user has access to this product
        if (!$isAdmin) {
            $hasPurchased = $user && $user->orders()
                ->where('status', 'completed')
                ->where('product_id', $product->id)
                ->exists();
                
            if (!$hasPurchased) {
                abort(403, 'You must purchase this product to access its content.');
            }
        }
        
        // Only show published content (unless admin)
        if (!$isAdmin && !$content->is_published) {
            abort(404);
        }
        
        // Load content blocks
        $content->load('blocks');
        
        // Load related content for navigation
        $allContent = $product->contents()
            ->when(!$isAdmin, function ($query) {
                $query->where('is_published', true);
            })
            ->orderBy('section_order')
            ->get();
            
        return Inertia::render('Customer/Product/Content', [
            'product' => $product,
            'content' => $content,
            'allContent' => $allContent,
            'isAdminPreview' => $isAdmin
        ]);
    }
}
