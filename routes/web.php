<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Include auth routes first, but our home route will override the default behavior
require __DIR__.'/auth.php';
require __DIR__.'/admin_web.php';

// Homepage - This is the default landing page for all visitors
// Make sure this route is defined at the top to take precedence
Route::get('/', [ProductController::class, 'home'])->name('home');

// Terms and Conditions
Route::get('/terms', function() {
    return Inertia::render('TermsAndConditions');
})->name('terms');

// Guest checkout routes
Route::prefix('guest')->name('guest.')->group(function() {
    Route::get('/checkout/{product}', [CheckoutController::class, 'guestCheckout'])->name('checkout');
    Route::post('/process-payment', [CheckoutController::class, 'processGuestPayment'])->name('process-payment');
    Route::get('/thank-you', [CheckoutController::class, 'guestThankYou'])->name('thank-you');
    Route::get('/complete-registration', [CheckoutController::class, 'completeRegistration'])->name('complete-registration');
    Route::post('/register', [CheckoutController::class, 'registerAfterPurchase'])->name('register');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/products-catalog', [App\Http\Controllers\ProductController::class, 'catalog'])
    ->middleware(['auth', 'verified'])
    ->name('products');

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
Route::post('/stripe/webhook', [App\Http\Controllers\StripeWebhookController::class, 'handleWebhook'])->name('stripe.webhook');

// Checkout Routes
Route::middleware('auth')->group(function () {
    // Checkout requires authentication
    Route::get('/checkout/{product}', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/payment/process', [CheckoutController::class, 'processPayment'])->name('process.payment');
    Route::post('/payment/process/ach', [CheckoutController::class, 'processAchPayment'])->name('process.payment.ach');
    Route::get('/checkout/thank-you/{order}', [CheckoutController::class, 'thankYou'])->name('checkout.thankyou');
    
    // Discount code validation
    Route::post('/discount/validate', [App\Http\Controllers\DiscountController::class, 'validateCode'])->name('discount.validate');
    
    // Admin Routes (add middleware for admin check)
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        // Product management is now defined in routes/admin.php
        // No longer defining product routes here to avoid conflicts
        
        // Order management routes are now defined in routes/admin.php
        // No longer defining order routes here to avoid conflicts
        
        // Users Management
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::post('users/{user}/toggle-admin', [App\Http\Controllers\Admin\UserController::class, 'toggleAdminStatus'])->name('users.toggle-admin');
        Route::get('users/{user}/orders', [App\Http\Controllers\Admin\UserController::class, 'orders'])->name('users.orders');
        
        // Products Management
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
        
        // Discounts Management is now defined in routes/admin.php
        // No longer defining discount routes here to avoid conflicts
    });
});
