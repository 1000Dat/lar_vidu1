<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Đây là nơi bạn có thể đăng ký các route web cho ứng dụng của bạn.
| Các route này sẽ được nạp bởi RouteServiceProvider và tất cả chúng
| sẽ được gán vào nhóm middleware "web".
|
*/

// Trang chính của ứng dụng
Route::get('/', function () {
    return view('welcome');
});

// Route resource cho các danh mục
Route::resource('categories', CategoryController::class);

// Route resource cho các sản phẩm
Route::resource('products', ProductController::class);
 