<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display the homepage with featured product.
     */
    public function home()
    {
        $featuredProduct = Product::where('active', true)->first();
        
        // Get all active products for display to guests
        $products = Product::where('active', true)->get();
        
        // Get the first active discount that is currently valid
        $activeDiscount = Discount::where('active', true)
            ->where(function ($query) {
                $query->whereNull('valid_from')
                      ->orWhere('valid_from', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('valid_until')
                      ->orWhere('valid_until', '>=', now());
            })
            ->where(function ($query) {
                $query->whereNull('max_uses')
                      ->orWhereRaw('used < max_uses');
            })
            ->first();
        
        // Calculate discounted price if discount exists
        $discountData = null;
        if ($activeDiscount && $featuredProduct) {
            $discountAmount = 0;
            $discountedPrice = $featuredProduct->price;
            
            if ($activeDiscount->type === 'percentage') {
                $discountAmount = ($featuredProduct->price * $activeDiscount->value) / 100;
                $discountedPrice = $featuredProduct->price - $discountAmount;
            } else { // fixed amount
                $discountAmount = $activeDiscount->value;
                $discountedPrice = max(0, $featuredProduct->price - $activeDiscount->value);
            }
            
            $discountData = [
                'code' => $activeDiscount->code,
                'type' => $activeDiscount->type,
                'value' => $activeDiscount->value,
                'description' => $activeDiscount->description,
                'valid_until' => $activeDiscount->valid_until?->toISOString(),
                'discounted_price' => round($discountedPrice, 2),
                'discount_amount' => round($discountAmount, 2),
                'discount_percentage' => $activeDiscount->type === 'percentage' 
                    ? $activeDiscount->value 
                    : round(($discountAmount / $featuredProduct->price) * 100, 0),
            ];
        }
        
        return Inertia::render('Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'featuredProduct' => $featuredProduct,
            'products' => $products,
            'guestCheckout' => true,
            'activeDiscount' => $discountData,
        ]);
    }
    
    /**
     * Display the catalog of products for authenticated users.
     */
    public function catalog(Request $request)
    {
        $user = $request->user();
        
        // Get all active products
        $products = Product::where('active', true)->get();
        
        // Get the first active discount that is currently valid
        $activeDiscount = Discount::where('active', true)
            ->where(function ($query) {
                $query->whereNull('valid_from')
                      ->orWhere('valid_from', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('valid_until')
                      ->orWhere('valid_until', '>=', now());
            })
            ->where(function ($query) {
                $query->whereNull('max_uses')
                      ->orWhereRaw('used < max_uses');
            })
            ->first();
        
        // Apply discount to products if active discount exists
        if ($activeDiscount) {
            $products = $products->map(function($product) use ($activeDiscount) {
                $originalPrice = $product->price;
                
                if ($activeDiscount->type === 'percentage') {
                    $discountAmount = ($originalPrice * $activeDiscount->value) / 100;
                } else {
                    $discountAmount = $activeDiscount->value;
                }
                
                $product->original_price = $originalPrice;
                $product->discounted_price = max(0, $originalPrice - $discountAmount);
                $product->discount_percentage = $activeDiscount->type === 'percentage' 
                    ? $activeDiscount->value 
                    : round(($discountAmount / $originalPrice) * 100, 0);
                $product->has_active_discount = true;
                
                return $product;
            });
        }
        
        // Get user's purchased products
        $userProducts = $user->orders()
            ->where('status', 'completed')
            ->with('product')
            ->get()
            ->pluck('product');
            
        return Inertia::render('Products', [
            'products' => $products,
            'userProducts' => $userProducts,
        ]);
    }

    /**
     * Display the landing page for a specific product.
     */
    public function show(Request $request, Product $product)
    {
        if (!$product->active) {
            return redirect()->route('home');
        }
        
        $discountCode = $request->query('discount');
        $discount = null;
        
        if ($discountCode) {
            $discount = Discount::where('code', $discountCode)
                ->where('active', true)
                ->first();
        }
        
        // Check if user has purchased this product
        $hasPurchased = false;
        $hasContent = false;
        
        if (auth()->check()) {
            $hasPurchased = \App\Models\Order::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->where('status', 'completed')
                ->exists();
            
            // Check if product has published content
            $hasContent = \App\Models\ProductContent::where('product_id', $product->id)
                ->where('is_published', true)
                ->exists();
        }
        
        return Inertia::render('Products/Landing', [
            'product' => $product,
            'discountCode' => $discount ? $discount->code : null,
            'hasPurchased' => $hasPurchased,
            'hasContent' => $hasContent,
        ]);
    }
}
