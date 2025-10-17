<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect users to login if they aren't authenticated
Route::redirect('/', '/login');

// Admin routes (protected by auth and admin middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin dashboard
    Route::get('/dashboard', function() {
        return Inertia::render('Admin/Dashboard');
    })->name('dashboard');
    
    // Import controller routes from admin.php
    require base_path('routes/admin.php');
});