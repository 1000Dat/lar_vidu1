<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Hiển thị danh mục
    public function index()
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem danh mục.');
        }

        // Kiểm tra xem người dùng có phải là admin không
        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
        }

        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    // Hiển thị danh sách các danh mục
    public function categories()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    // Hiển thị form thêm mới danh mục
    public function createCategory()
    {
        return view('admin.categories.create');
    }

    // Lưu danh mục vào cơ sở dữ liệu
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        Category::create($request->all());
        return redirect()->route('admin.categories')->with('success', 'Danh mục đã được thêm thành công.');
    }

    // Hiển thị form chỉnh sửa danh mục
    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Cập nhật thông tin danh mục
    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->all());
        return redirect()->route('admin.categories')->with('success', 'Danh mục đã được cập nhật thành công.');
    }

    // Xóa danh mục
    public function destroyCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Danh mục đã được xóa thành công.');
    }

    // Hiển thị danh sách sản phẩm
    public function products()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    // Hiển thị form thêm mới sản phẩm
    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Lưu sản phẩm vào cơ sở dữ liệu
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/images');
        }

        Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'quantity' => $request->input('quantity'),
            'price' => $request->input('price'),
            'category_id' => $request->input('category_id'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Sản phẩm đã được thêm thành công.');
    }

    // Hiển thị form chỉnh sửa sản phẩm
    public function editProduct(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Cập nhật thông tin sản phẩm
    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($imagePath && Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }

            $image = $request->file('image');
            $imagePath = $image->store('public/images');
        }

        $product->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'quantity' => $request->input('quantity'),
            'price' => $request->input('price'),
            'category_id' => $request->input('category_id'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }

    // Xóa sản phẩm
    public function destroyProduct(Product $product)
    {
        // Xóa hình ảnh nếu có
        if ($product->image && Storage::exists($product->image)) {
            Storage::delete($product->image);
        }

        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Sản phẩm đã được xóa thành công.');
    }

    // Hiển thị hình ảnh sản phẩm
    public function showProductImage($productId)
    {
        $product = Product::findOrFail($productId);
        $imagePath = storage_path('app/public/images/' . $product->image);

        if (file_exists($imagePath)) {
            return response()->file($imagePath);
        } else {
            abort(404, 'Image not found');
        }
    }

    
    public function reports()
    {
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalRevenue = Order::sum('total_price');
        
        // Lấy sản phẩm đã bán trong vòng 1 tháng và thống kê theo ngày
        $productsSoldLastMonth = Product::withSum('orderItems', 'quantity')
            ->whereHas('orderItems', function($query) {
                $query->where('created_at', '>=', now()->subMonth());
            })
            ->get()
            ->map(function ($product) {
                $product->sold_quantity = $product->order_items_sum_quantity; // Số lượng đã bán
                $product->remaining_stock = $product->quantity; // Số lượng còn lại trong kho
                return $product;
            });
    
        // Thống kê doanh thu và số lượng đơn hàng theo ngày
        $dailySales = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as daily_revenue, COUNT(*) as total_orders')
            ->where('created_at', '>=', now()->subMonth())
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        return view('admin.reports', compact('totalOrders', 'totalProducts', 'totalRevenue', 'productsSoldLastMonth', 'dailySales'));
    }
    
    
    
    

}
