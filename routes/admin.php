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
        
        // Product Content Management
        Route::get('products/{product}/content', [\App\Http\Controllers\Admin\ProductContentController::class, 'index'])->name('products.content.index');
        Route::get('products/{product}/content/create', [\App\Http\Controllers\Admin\ProductContentController::class, 'create'])->name('products.content.create');
        Route::post('products/{product}/content', [\App\Http\Controllers\Admin\ProductContentController::class, 'store'])->name('products.content.store');
        Route::get('products/{product}/content/{content}/edit', [\App\Http\Controllers\Admin\ProductContentController::class, 'edit'])->name('products.content.edit');
        Route::put('products/{product}/content/{content}', [\App\Http\Controllers\Admin\ProductContentController::class, 'update'])->name('products.content.update');
        Route::delete('products/{product}/content/{content}', [\App\Http\Controllers\Admin\ProductContentController::class, 'destroy'])->name('products.content.destroy');
        Route::post('products/{product}/content/reorder', [\App\Http\Controllers\Admin\ProductContentController::class, 'reorder'])->name('products.content.reorder');
        
        // Content Blocks Management
        Route::post('products/{product}/content/{content}/blocks', [\App\Http\Controllers\Admin\ProductContentController::class, 'storeBlock'])->name('products.content.blocks.store');
        Route::put('products/{product}/content/{content}/blocks/{block}', [\App\Http\Controllers\Admin\ProductContentController::class, 'updateBlock'])->name('products.content.blocks.update');
        Route::delete('products/{product}/content/{content}/blocks/{block}', [\App\Http\Controllers\Admin\ProductContentController::class, 'destroyBlock'])->name('products.content.blocks.destroy');
        Route::post('products/{product}/content/{content}/blocks/reorder', [\App\Http\Controllers\Admin\ProductContentController::class, 'reorderBlocks'])->name('products.content.blocks.reorder');
        
        // Discounts Management
        Route::resource('discounts', DiscountController::class);
        
        // Reports
        Route::get('reports', [ReportController::class, 'index'])->name('reports');
        Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
    });
});