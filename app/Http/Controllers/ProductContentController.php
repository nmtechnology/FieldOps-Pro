<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductContentController extends Controller
{
    /**
     * Display the table of contents for a product
     */
    public function tableOfContents($productId)
    {
        // Get the product with its table of contents
        $product = \App\Models\Product::with(['publishedContents' => function($query) {
            // Include only section metadata, not full content
            $query->select('id', 'product_id', 'title', 'slug', 'section_type', 'section_order', 'is_premium');
        }])->findOrFail($productId);
        
        // Check if the user has purchased this product
        $hasPurchased = false;
        if (auth()->check()) {
            $hasPurchased = \App\Models\Order::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->where('status', 'completed')
                ->exists();
        }

        return \Inertia\Inertia::render('Products/TableOfContents', [
            'product' => $product,
            'hasPurchased' => $hasPurchased,
            'contents' => $product->publishedContents,
        ]);
    }

    /**
     * Display a specific content section
     */
    public function show($productId, $slug)
    {
        // Get the product and the specific content section
        $product = \App\Models\Product::findOrFail($productId);
        $content = \App\Models\ProductContent::where('product_id', $productId)
            ->where('slug', $slug)
            ->where('is_published', true)
            ->with('blocks') // Load content blocks
            ->firstOrFail();
        
        // If the content is premium, check if the user has purchased it
        if ($content->is_premium) {
            if (!auth()->check()) {
                // Redirect to login if not authenticated
                return redirect()->route('login')->with('message', 'Please login to access premium content');
            }
            
            $hasPurchased = \App\Models\Order::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->where('status', 'completed')
                ->exists();
            
            if (!$hasPurchased) {
                // Redirect to product page if not purchased
                return redirect()->route('products.show', $productId)
                    ->with('error', 'You need to purchase this product to access premium content');
            }
        }
        
        // Get next and previous sections for navigation
        $nextContent = \App\Models\ProductContent::where('product_id', $productId)
            ->where('section_order', '>', $content->section_order)
            ->where('is_published', true)
            ->orderBy('section_order')
            ->first();
        
        $prevContent = \App\Models\ProductContent::where('product_id', $productId)
            ->where('section_order', '<', $content->section_order)
            ->where('is_published', true)
            ->orderBy('section_order', 'desc')
            ->first();
        
        return \Inertia\Inertia::render('Products/ContentSection', [
            'product' => $product,
            'content' => $content,
            'nextSection' => $nextContent ? [
                'title' => $nextContent->title,
                'slug' => $nextContent->slug,
            ] : null,
            'prevSection' => $prevContent ? [
                'title' => $prevContent->title,
                'slug' => $prevContent->slug,
            ] : null,
        ]);
    }
    
    /**
     * Display the downloadable resources
     */
    public function downloads($productId)
    {
        // Get the product
        $product = \App\Models\Product::findOrFail($productId);
        
        // Check if the user has purchased this product
        if (!auth()->check()) {
            return redirect()->route('login')->with('message', 'Please login to access downloads');
        }
        
        $hasPurchased = \App\Models\Order::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->where('status', 'completed')
            ->exists();
        
        if (!$hasPurchased) {
            return redirect()->route('products.show', $productId)
                ->with('error', 'You need to purchase this product to access downloads');
        }
        
        // Get all downloadable content
        $downloadables = \App\Models\ProductContent::where('product_id', $productId)
            ->where('is_published', true)
            ->whereNotNull('downloads')
            ->get();
        
        return \Inertia\Inertia::render('Products/Downloads', [
            'product' => $product,
            'downloadables' => $downloadables,
        ]);
    }
    
    /**
     * Download a specific file
     */
    public function download($productId, $contentId, $fileIndex)
    {
        // Check if the user has purchased this product
        if (!auth()->check()) {
            return redirect()->route('login')->with('message', 'Please login to download files');
        }
        
        $hasPurchased = \App\Models\Order::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->where('status', 'completed')
            ->exists();
        
        if (!$hasPurchased) {
            return redirect()->route('products.show', $productId)
                ->with('error', 'You need to purchase this product to download files');
        }
        
        // Get the content with the file
        $content = \App\Models\ProductContent::where('product_id', $productId)
            ->where('id', $contentId)
            ->where('is_published', true)
            ->firstOrFail();
        
        $downloads = $content->downloads ?? [];
        
        if (!isset($downloads[$fileIndex])) {
            return back()->with('error', 'File not found');
        }
        
        $file = $downloads[$fileIndex];
        
        // Return the file download
        return response()->download(
            storage_path('app/public/' . $file['path']), 
            $file['name']
        );
    }
}
