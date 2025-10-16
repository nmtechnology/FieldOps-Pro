<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Homepage
Route::get('/', [ProductController::class, 'home'])->name('home');

// Terms and Conditions
Route::get('/terms', function() {
    return Inertia::render('TermsAndConditions');
})->name('terms');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Product access
    Route::get('/products/access/{productId}', [App\Http\Controllers\DashboardController::class, 'accessProduct'])
        ->name('products.access');
        
    // Premium content routes (require authentication)
    Route::get('/products/{productId}/toc', [App\Http\Controllers\ProductContentController::class, 'tableOfContents'])
        ->name('products.toc');
    Route::get('/products/{productId}/content/{slug}', [App\Http\Controllers\ProductContentController::class, 'show'])
        ->name('products.content.show');
    Route::get('/products/{productId}/downloads', [App\Http\Controllers\ProductContentController::class, 'downloads'])
        ->name('products.downloads');
    Route::get('/products/{productId}/download/{contentId}/{fileIndex}', [App\Http\Controllers\ProductContentController::class, 'download'])
        ->name('products.download');
});

// Product Routes
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Stripe Webhook Route (exclude from CSRF verification)
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook'])->name('stripe.webhook');

// Checkout Routes
Route::middleware('auth')->group(function () {
    // Checkout requires authentication
    Route::get('/checkout/{product}', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/payment/process', [CheckoutController::class, 'processPayment'])->name('process.payment');
    Route::post('/payment/process/ach', [CheckoutController::class, 'processAchPayment'])->name('process.payment.ach');
    Route::get('/checkout/thank-you/{order}', [CheckoutController::class, 'thankYou'])->name('checkout.thankyou');
    
    // Discount code validation
    Route::post('/discount/validate', [DiscountController::class, 'validateCode'])->name('discount.validate');
    
    // Admin Routes (add middleware for admin check)
    Route::middleware('admin')->group(function () {
        // Product management
        Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
        
        // Order management
        Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/admin/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::post('/admin/orders/{order}/refund', [OrderController::class, 'refund'])->name('admin.orders.refund');
        
        // Discount management
        Route::get('/admin/discounts', [DiscountController::class, 'index'])->name('admin.discounts.index');
        Route::post('/admin/discounts', [DiscountController::class, 'store'])->name('admin.discounts.store');
        Route::put('/admin/discounts/{discount}', [DiscountController::class, 'update'])->name('admin.discounts.update');
        Route::delete('/admin/discounts/{discount}', [DiscountController::class, 'destroy'])->name('admin.discounts.destroy');
    });
});

require __DIR__.'/auth.php';
