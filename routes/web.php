<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\OrderController;

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

    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');


   


    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::post('/payment/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');
    Route::post('/payment/process', [YourControllerName::class, 'processPaymentview'])->name('payment.process');
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');



Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth');

Route::resource('orders', OrderController::class);
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');


    // Routes admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Danh mục
    Route::get('categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
    Route::post('categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('categories/{category}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::put('categories/{category}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('categories/{category}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');

    // Sản phẩm
    Route::get('products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('products/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
});

    
});
