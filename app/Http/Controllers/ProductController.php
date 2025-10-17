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
        
        return Inertia::render('Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'featuredProduct' => $featuredProduct,
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
