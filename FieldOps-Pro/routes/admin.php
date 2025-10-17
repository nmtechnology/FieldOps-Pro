<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ReportController;
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

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->middleware([App\Http\Middleware\AdminMiddleware::class])
        ->name('dashboard');
    
    // Orders Management
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::resource('orders', OrderController::class);
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::post('orders/{order}/refund', [OrderController::class, 'processRefund'])->name('orders.refund');
        
        // Users Management
        Route::resource('users', UserController::class);
        Route::post('users/{user}/toggle-admin', [UserController::class, 'toggleAdminStatus'])->name('users.toggle-admin');
        Route::get('users/{user}/orders', [UserController::class, 'orders'])->name('users.orders');
        
        // Products Management
        Route::resource('products', ProductController::class);
        
        // Discounts Management
        Route::resource('discounts', DiscountController::class);
        
        // Reports
        Route::get('reports', [ReportController::class, 'index'])->name('reports');
        Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
    });
});