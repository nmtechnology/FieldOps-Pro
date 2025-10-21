<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductContent;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $products = Product::withCount(['orders'])
            ->latest()
            ->paginate(10);
        
        return Inertia::render('Admin/Products/Index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        // Get available default images
        $defaultImages = Product::getAvailableDefaultImages();
        
        return Inertia::render('Admin/Products/Create', [
            'defaultImages' => $defaultImages
        ]);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string',
            'type' => 'required|string|in:info,service,physical',
            'price' => 'required|numeric|min:0',
            'image_path' => 'nullable|string|url',
            'active' => 'boolean',
            'content_sections' => 'nullable|array'
        ]);

        $product = Product::create($validated);
        
        // Assign default image if no image was provided
        $product->assignDefaultImageIfNeeded();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Inertia\Response
     */
    public function show(Product $product)
    {
        $product->load(['contents']);
        $product->loadCount(['orders']);
        
        return Inertia::render('Admin/Products/Show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Inertia\Response
     */
    public function edit(Product $product)
    {
        // Get available default images
        $defaultImages = Product::getAvailableDefaultImages();
        
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
            'defaultImages' => $defaultImages
        ]);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'short_description' => 'nullable|string',
            'type' => 'sometimes|string|in:info,service,physical',
            'price' => 'sometimes|numeric|min:0',
            'image_path' => 'nullable|string|url',
            'active' => 'sometimes|boolean',
            'content_sections' => 'nullable|array'
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        // Check if the product has associated orders
        if ($product->orders()->exists()) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Cannot delete product with existing orders.');
        }
        
        // Delete associated content first
        $product->contents()->delete();
        
        // Delete the product
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
