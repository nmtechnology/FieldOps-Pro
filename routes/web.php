<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Health check endpoint for load balancers and monitoring (no middleware, no DB)
Route::get('/health', function() {
    return response()->json([
        'status' => 'ok',
        'timestamp' => time(),
    ], 200);
})->name('health');

// Include auth routes first, but our home route will override the default behavior
require __DIR__.'/auth.php';
require __DIR__.'/admin_web.php';

// Bot verification page - THE FIRST PAGE at root
Route::get('/', function() {
    // If already verified, go to home
    if (session()->has('human_verified')) {
        return app(ProductController::class)->home();
    }
    return Inertia::render('BotCheck');
})->name('bot-check');

Route::post('/verify', function(Illuminate\Http\Request $request) {
    // Set verification in session
    $request->session()->put('human_verified', true);
    $request->session()->save();
    
    // Log for debugging
    \Log::info('Verification set', [
        'session_id' => session()->getId(),
        'has_verified' => session()->has('human_verified'),
        'verified_value' => session()->get('human_verified')
    ]);
    
    // Redirect to loading screen using Inertia redirect
    return redirect()->route('loading-to-home');
})->name('verify');

// Homepage - Real home page after verification
Route::get('/home', [ProductController::class, 'home'])
    ->middleware('verify.human')
    ->name('home');

// Terms and Conditions
Route::get('/terms', function() {
    return Inertia::render('TermsAndConditions');
})->middleware('verify.human')->name('terms');

// Guest checkout routes - all protected by verification
Route::prefix('guest')->name('guest.')->middleware('verify.human')->group(function() {
    Route::get('/checkout/{product}', [CheckoutController::class, 'guestCheckout'])->name('checkout');
    Route::post('/checkout/calculate-tax', [CheckoutController::class, 'calculateTax'])->name('checkout.calculate-tax');
    Route::post('/process-payment', [CheckoutController::class, 'processGuestPayment'])->name('process-payment');
    Route::post('/coinbase-payment', [App\Http\Controllers\CoinbasePaymentController::class, 'guestCheckout'])->name('coinbase-payment');
    Route::get('/thank-you', [CheckoutController::class, 'guestThankYou'])->name('thank-you');
    Route::get('/complete-registration', [CheckoutController::class, 'completeRegistration'])->name('complete-registration');
    Route::post('/register', [CheckoutController::class, 'registerAfterPurchase'])->name('register');
});

// Loading screen after login
Route::get('/loading', function() {
    return Inertia::render('Auth/Loading');
})->middleware('auth')->name('loading');

// Loading screen after bot verification (redirects to home)
// No middleware here - session was just set by /verify endpoint
Route::get('/loading-to-home', function(Illuminate\Http\Request $request) {
    // Log for debugging
    \Log::info('Loading-to-home accessed', [
        'session_id' => session()->getId(),
        'has_verified' => session()->has('human_verified'),
        'verified_value' => session()->get('human_verified'),
        'all_session' => $request->session()->all()
    ]);
    
    // Double check session is set, if not redirect back to verification
    if (!session()->has('human_verified')) {
        \Log::warning('No verification in session at loading-to-home');
        return redirect('/');
    }
    return Inertia::render('Auth/LoadingToHome');
})->name('loading-to-home');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'verify.human'])
    ->name('dashboard');

Route::get('/products-catalog', [App\Http\Controllers\ProductController::class, 'catalog'])
    ->middleware(['auth', 'verified', 'verify.human'])
    ->name('products');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Product access
    Route::get('/products/access/{productId}', [App\Http\Controllers\DashboardController::class, 'accessProduct'])
        ->name('products.access');
        
    // Customer product experience (purchased products)
    Route::get('/my-products/{product}', [CustomerProductController::class, 'show'])
        ->name('customer.products.show');
    Route::get('/my-products/{product}/content/{content}', [CustomerProductController::class, 'showContent'])
        ->name('customer.products.content');
        
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
Route::get('/products/{product}', [ProductController::class, 'show'])
    ->middleware('verify.human')
    ->name('products.show');

// Stripe Webhook Route (exclude from CSRF verification)
Route::post('/stripe/webhook', [App\Http\Controllers\StripeWebhookController::class, 'handleWebhook'])->name('stripe.webhook');

// Coinbase Commerce Webhook Route (exclude from CSRF verification)
Route::post('/coinbase/webhook', [App\Http\Controllers\CoinbaseWebhookController::class, 'handle'])->name('coinbase.webhook');

// Checkout Routes
Route::middleware('auth')->group(function () {
    // Checkout requires authentication
    Route::get('/checkout/{product}', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/calculate-tax', [CheckoutController::class, 'calculateTax'])->name('checkout.calculate-tax');
    Route::post('/payment/process', [CheckoutController::class, 'processPayment'])->name('process.payment');
    Route::post('/payment/process/ach', [CheckoutController::class, 'processAchPayment'])->name('process.payment.ach');
    Route::get('/checkout/thank-you/{order}', [CheckoutController::class, 'thankYou'])->name('checkout.thankyou');
    
    // Coinbase Commerce payment routes
    Route::post('/payment/coinbase', [App\Http\Controllers\CoinbasePaymentController::class, 'checkout'])->name('payment.coinbase');
    
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
