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
        
        return Inertia::render('Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'featuredProduct' => $featuredProduct,
            'products' => $products,
            'guestCheckout' => true,
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
        
        return Inertia::render('Products/Landing', [
            'product' => $product,
            'discountCode' => $discount ? $discount->code : null,
        ]);
    }
}
