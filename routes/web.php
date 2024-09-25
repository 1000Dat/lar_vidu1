<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\DashboardController;

// Routes for guest access (registration, login)
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'registerUser']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'loginUser']);
Route::post('logout', [AuthController::class, 'logoutUser'])->name('logout');

// Routes for authenticated users
Route::middleware('auth')->group(function () {
    // Home route
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Products and categories
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    // Cart routes
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Admin categories
        Route::resource('admin/categories', CategoryController::class);

        // Admin products
        Route::resource('admin/products', ProductController::class)->except(['index', 'show']);
    });
});
