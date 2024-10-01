<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Product;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Lấy tất cả đơn hàng cho người dùng hiện tại và sắp xếp theo thời gian tạo mới nhất
        $orders = Order::where('user_id', auth()->id())
                       ->orderBy('created_at', 'desc') // Sắp xếp theo created_at mới nhất lên đầu
                       ->get();
    
        // Trả về view và truyền dữ liệu đơn hàng
        return view('order.history', compact('orders'));
    }
    
    public function show($id)
    {
        // Lấy đơn hàng theo ID và eager load orderItems cùng với sản phẩm
        $order = Order::with('orderItems.product')->findOrFail($id);
    
        return view('order.show', compact('order'));
    }
    
   public function destroy($id)
{
    // Retrieve the order by ID
    $order = Order::findOrFail($id);

    // Loop through each product in the order
    foreach ($order->orderItems as $item) {
        // Find the product by ID
        $product = Product::findOrFail($item->product_id);
        
        // Increase the product's quantity by the quantity in the order item
        $product->quantity += $item->quantity;
        
        // Save the updated product quantity
        $product->save();
    }

    // Delete the order
    $order->delete();
    
    // Redirect with a success message
    return redirect()->route('orders.index')->with('message', 'Đơn hàng đã được xóa thành công và số lượng sản phẩm đã được cập nhật.');
}

    
}
