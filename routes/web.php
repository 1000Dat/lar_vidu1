<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;

// routes/web.php

use App\Http\Controllers\Admin\DashboardController;

// routes/web.php
// Hiển thị các sản phẩm của danh mục



Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');

Route::post('admin/products/{product}/image', [AdminController::class, 'uploadProductImage'])->name('admin.products.image');


Route::resource('admin/products', ProductController::class);



Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('admin/categories', CategoryController::class);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('admin/products', CategoryController::class);
});

Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


// routes/web.php

Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    // Thêm các route khác cần bảo vệ ở đây
});

// Routes cho người dùng
Route::middleware('auth')->group(function () {
    Route::resource('categories', CategoryController::class);;
    // Route::resource('categories', CategoryController::class)->only(['index', 'show']);
    // Route::resource('products', ProductController::class)  ->only(['index', 'show']);
    Route::resource('products', ProductController::class);
});

// Routes cho trang chính
Route::middleware('auth')->get('/', [HomeController::class, 'index'])->name('home');

// Routes cho đăng ký, đăng nhập và đăng xuất
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'registerUser']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'loginUser']);
Route::post('logout', [AuthController::class, 'logoutUser'])->name('logout');

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

