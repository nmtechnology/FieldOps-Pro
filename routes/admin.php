<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\CustomerProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| These routes are protected by the admin middleware and are only accessible
| to users with admin privileges.
|
*/

Route::middleware(['auth'])->group(function () {
    // Admin Dashboard route is defined in admin_web.php
    // These routes are loaded inside admin_web.php which already has prefix('admin') and name('admin.')
    
    // Orders Management
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::resource('orders', OrderController::class);
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::post('orders/{order}/refund', [OrderController::class, 'processRefund'])->name('orders.refund');
        
        // Users Management
        // Route::resource('users', UserController::class); // Moved to admin_web.php
        Route::post('users/{user}/toggle-admin', [UserController::class, 'toggleAdminStatus'])->name('users.toggle-admin');
        Route::get('users/{user}/orders', [UserController::class, 'orders'])->name('users.orders');
        
        // Products Management
        Route::resource('products', ProductController::class);
        Route::get('products/{product}/preview', [CustomerProductController::class, 'show'])->name('products.preview');
        Route::get('products/{product}/preview/content/{content}', [CustomerProductController::class, 'showContent'])->name('products.preview.content');
        
        // Discounts Management
        Route::resource('discounts', DiscountController::class);
        
        // Reports
        Route::get('reports', [ReportController::class, 'index'])->name('reports');
        Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
    });
});