<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        // Middleware xác thực người dùng và giới hạn quyền admin cho các hành động cụ thể
        $this->middleware('auth');
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    // Hiển thị danh sách sản phẩm
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem sản phẩm.');
        }
    
        // Lấy tất cả sản phẩm cùng với danh mục của chúng
        $products = Product::with('category')->get(); 
    
        return view('products.index', compact('products'));
    }

     // Hiển thị chi tiết sản phẩm
     public function show($id)
     {
         $product = Product::findOrFail($id);
         return view('products.show', compact('product'));
     }
}



//     // Hiển thị form tạo sản phẩm mới (chỉ dành cho admin)
//     public function create()
//     {
//         $categories = Category::all();  // Lấy tất cả danh mục
//         return view('admin.products.create', compact('categories'));
//     }

//     // Lưu sản phẩm mới vào cơ sở dữ liệu (chỉ dành cho admin)
   
// public function store(Request $request)
// {
//     // Xác thực dữ liệu
//     $request->validate([
//         'name' => 'required|string|max:255',
//         'description' => 'nullable|string',
//         'quantity' => 'required|integer',
//         'price' => 'required|numeric',
//         'category_id' => 'required|exists:categories,id',
//         'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Xác thực file ảnh
//     ]);

//     // Xử lý ảnh nếu có
//     $imageName = null;
//     if ($request->hasFile('img')) {
//         // Tạo tên file duy nhất dựa trên thời gian hiện tại
//         $imageName = time() . '.' . $request->img->extension();
//         // Di chuyển file ảnh đến thư mục public/images
//         $request->img->move(public_path('images'), $imageName);
//     }

//     // Tạo sản phẩm mới và lưu tên ảnh vào cơ sở dữ liệu
//     Product::create([
//         'name' => $request->name,
//         'description' => $request->description,
//         'quantity' => $request->quantity,
//         'price' => $request->price,
//         'category_id' => $request->category_id,
//         'img' => $imageName, // Lưu tên ảnh vào cơ sở dữ liệu
//     ]);

//     // Chuyển hướng về trang danh sách sản phẩm với thông báo thành công
//     return redirect()->route('products.index')->with('success', 'Product created successfully.');
// }


    
//     // Hiển thị form chỉnh sửa sản phẩm (chỉ dành cho admin)
//     public function edit(Product $product)
//     {
//         $categories = Category::all();
//         return view('products.edit', compact('product', 'categories'));
//     }

//     // Cập nhật sản phẩm (chỉ dành cho admin)
//     public function update(Request $request, Product $product)
//     {
//         // Validate dữ liệu nhập vào
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'description' => 'nullable|string',
//             'quantity' => 'required|integer|min:1',
//             'price' => 'required|numeric|min:0',
//             'category_id' => 'required|exists:categories,id',
//             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Validate ảnh
//         ]);

//         // Xử lý ảnh nếu có
//         if ($request->hasFile('image')) {
//             // Xóa ảnh cũ nếu tồn tại
//             if ($product->image && file_exists(public_path('images/' . $product->image))) {
//                 unlink(public_path('images/' . $product->image));
//             }

//             $image = $request->file('image');
//             $imageName = time() . '.' . $image->getClientOriginalExtension(); // Tạo tên ảnh mới
//             $image->move(public_path('images'), $imageName); // Lưu ảnh vào thư mục public/images
//             $product->image = $imageName; // Cập nhật tên ảnh trong cơ sở dữ liệu
//         }

//         // Cập nhật các thông tin khác của sản phẩm
//         $product->update([
//             'name' => $request->name,
//             'description' => $request->description,
//             'quantity' => $request->quantity,
//             'price' => $request->price,
//             'category_id' => $request->category_id,
//         ]);

//         return redirect()->route('products.index')->with('success', 'Sản phẩm đã được cập nhật thành công.');
//     }

//     // Xóa sản phẩm (chỉ dành cho admin)
//     public function destroy(Product $product)
//     {
//         // Xóa ảnh nếu tồn tại
//         if ($product->image && file_exists(public_path('images/' . $product->image))) {
//             unlink(public_path('images/' . $product->image));
//         }

//         // Xóa sản phẩm khỏi cơ sở dữ liệu
//         $product->delete();

//         return redirect()->route('products.index')->with('success', 'Sản phẩm đã được xóa thành công.');
//     }
// }
