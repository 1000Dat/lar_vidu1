<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    public function indexAdmin()
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem danh mục.');
        }
    
        // Kiểm tra xem người dùng có phải là admin không
        if (Auth::user()->role !== 'admin') {
            // Nếu không phải admin, chuyển hướng về trang chính với thông báo lỗi
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
        }
    
        // Nếu đã đăng nhập và là admin, lấy tất cả danh mục
        $categories = Category::all();
    
        // Hiển thị trang danh mục với biến $categories
        return view('admin.categories.index', compact('categories'));
    }
    
    // Hiển thị danh sách danh mục
    public function index()
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem danh mục.');
        }

        // Nếu đã đăng nhập, lấy tất cả danh mục
        $categories = Category::all();

        // Hiển thị trang danh mục với biến $categories
        return view('categories.index', compact('categories'));
    }

    // Hiển thị danh mục cụ thể
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    

    // // Hiển thị form thêm mới danh mục (chỉ dành cho admin)
    // public function create()
    // {
    //     return view('admin.categories.create');
    // }

    // // Lưu danh mục vào cơ sở dữ liệu (chỉ dành cho admin)
    // public function store(Request $request)
    // {
    //     // Validate the incoming request data
    //     $request->validate([
    //         'name' => 'required|string|max:255|unique:categories',
    //     ]);

    //     // Check if the user is authenticated and is an admin
    //     if (!Auth::check() || Auth::user()->role !== 'admin') {
    //         return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
    //     }

    //     // Create a new category
    //     $category = new Category();
    //     $category->name = $request->input('name');
    //     $category->save();

    //     // Redirect to the index page with a success message
    //     return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được thêm thành công.');
    // }


    // // Hiển thị form chỉnh sửa danh mục (chỉ dành cho admin)
    // public function edit(Category $category)
    // {
    //     return view('categories.edit', compact('category'));
    // }

    // // Cập nhật thông tin danh mục (chỉ dành cho admin)
    // public function update(Request $request, Category $category)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
    //     ]);

    //     $category->update($request->all());  // Cập nhật danh mục

    //     return redirect()->route('categories.index')->with('success', 'Danh mục đã được cập nhật thành công.');
    // }

    // // Xóa danh mục (chỉ dành cho admin)
    // public function destroy(Category $category)
    // {
    //     $category->delete();  // Xóa danh mục

    //     return redirect()->route('categories.index')->with('success', 'Danh mục đã được xóa thành công.');
    // }
}
