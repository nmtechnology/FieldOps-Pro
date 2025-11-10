<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerProductController;
use App\Http\Controllers\ContactController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Health check endpoint for load balancers and monitoring
Route::get('/health', function() {
    $status = 'ok';
    $checks = [
        'app' => 'ok',
    ];
    
    // Try to check database connection
    try {
        \DB::connection()->getPdo();
        $checks['database'] = 'ok';
    } catch (\Exception $e) {
        $status = 'degraded';
        $checks['database'] = 'error';
    }
    
    return response()->json([
        'status' => $status,
        'checks' => $checks,
        'timestamp' => time(),
    ], $status === 'ok' ? 200 : 503);
})->name('health');

// Bot check page - MUST be defined before auth routes to ensure it's accessible
Route::get('/bot-check', function(Illuminate\Http\Request $request) {
    // Track the visitor when they first land
    try {
        $trackingService = app(\App\Services\VisitorTrackingService::class);
        $sessionId = $request->session()->getId();
        
        // Only create a record if one doesn't exist for this session
        $existingVisitor = \App\Models\VisitorLog::where('session_id', $sessionId)->first();
        if (!$existingVisitor) {
            $trackingService->trackVisitor($request);
        }
    } catch (\Exception $e) {
        \Log::error('Failed to track landing visitor: ' . $e->getMessage());
    }
    
    return Inertia::render('BotCheck');
})->name('bot-check');

// Home Page - Main advertising/product catalog page for verified visitors
Route::get('/', function() {
    // If logged in, redirect to dashboard - logged in users don't see the home page
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    
    // Get active products and featured product for the home page
    $products = \App\Models\Product::where('active', true)->get();
    $featuredProduct = $products->first(); // First active product as featured
    
    // Get active discount if any
    $activeDiscount = \App\Models\Discount::where('active', true)
        ->where(function($query) {
            $query->whereNull('valid_until')
                  ->orWhere('valid_until', '>=', now());
        })
        ->where(function($query) {
            $query->whereNull('max_uses')
                  ->orWhereRaw('used < max_uses');
        })
        ->first();
    
    // Show the main Home page (advertising/product catalog) to verified visitors
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'products' => $products,
        'featuredProduct' => $featuredProduct,
        'guestCheckout' => true,
        'activeDiscount' => $activeDiscount,
    ]);
})->middleware('verify.human')->name('home.index');

// Hero/Welcome page - Simple landing page (shown after logout, etc)
Route::get('/welcome', function() {
    // If logged in, redirect to dashboard
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    
    return Inertia::render('Hero', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('welcome');

Route::post('/verify', function(Illuminate\Http\Request $request) {
    // Set verification in session
    $request->session()->put('human_verified', true);
    $request->session()->save();
    
    // Track and notify about verified visitor
    try {
        $trackingService = app(\App\Services\VisitorTrackingService::class);
        $visitor = $trackingService->markAsVerified($request);
        
        // If no existing visitor record, create one
        if (!$visitor) {
            $visitor = $trackingService->trackVisitor($request);
            $visitor->update([
                'verified' => true,
                'verified_at' => now(),
            ]);
        }
        
        // Send notification emails to all admin addresses
        $adminEmails = config('mail.admin_emails', ['purchases@fieldengineerpro.com', 'patrick@nmtechnology.us']);
        foreach ($adminEmails as $email) {
            \Mail::to(trim($email))->send(new \App\Mail\VisitorVerified($visitor));
        }
        
        \Log::info('Visitor verified and tracked', [
            'visitor_id' => $visitor->id,
            'ip' => $visitor->ip_address,
            'location' => $visitor->city . ', ' . $visitor->country,
        ]);
    } catch (\Exception $e) {
        \Log::error('Failed to track visitor: ' . $e->getMessage());
        // Don't fail the verification if tracking fails
    }
    
    // Log for debugging
    \Log::info('Verification set', [
        'session_id' => session()->getId(),
        'has_verified' => session()->has('human_verified'),
        'verified_value' => session()->get('human_verified')
    ]);
    
    // Redirect to loading screen using Inertia redirect
    return redirect()->route('loading-to-home');
})->name('verify');

// Include auth and admin routes AFTER our public routes
require __DIR__.'/auth.php';
require __DIR__.'/admin_web.php';

// Terms and Conditions
Route::get('/terms', function() {
    return Inertia::render('TermsAndConditions');
})->name('terms');

// Contact/Support
Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

// Sitemap for SEO
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])
    ->name('sitemap');

// Guest checkout routes
Route::prefix('guest')->name('guest.')->group(function() {
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
    
    // Tutorial routes
    Route::get('/tutorial/{product}', [App\Http\Controllers\TutorialController::class, 'show'])
        ->name('tutorial.show');
    Route::post('/tutorial/complete', [App\Http\Controllers\TutorialController::class, 'complete'])
        ->name('tutorial.complete');
    Route::get('/tutorial/{product}/certificate', [App\Http\Controllers\TutorialController::class, 'certificate'])
        ->name('tutorial.certificate');
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
