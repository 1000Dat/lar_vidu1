<?php

namespace App\Http\Controllers;

use App\Models\Category; // Thêm dòng này để import model Category
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // Lấy tất cả các category
        return view('categories.index', compact('categories')); // Trả view với danh sách categories
    }

    public function create()
    {
        return view('categories.create'); // Trả view tạo mới category
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->save(); // Lưu category vào cơ sở dữ liệu

        return redirect()->route('categories.index'); // Chuyển hướng về danh sách categories
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id); // Lấy category theo ID hoặc lỗi 404 nếu không tìm thấy
        return view('categories.edit', compact('category')); // Trả view chỉnh sửa category
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id); // Lấy category theo ID hoặc lỗi 404 nếu không tìm thấy
        $category->name = $request->name;
        $category->save(); // Cập nhật category vào cơ sở dữ liệu

        return redirect()->route('categories.index'); // Chuyển hướng về danh sách categories
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id); // Lấy category theo ID hoặc lỗi 404 nếu không tìm thấy
        $category->delete(); // Xóa category khỏi cơ sở dữ liệu

        return redirect()->route('categories.index'); // Chuyển hướng về danh sách categories
    }
}
