<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // Hiển thị danh sách tất cả đơn hàng
    public function index()
    {
        // Lấy tất cả đơn hàng cùng với thông tin khách hàng, sắp xếp theo ngày tạo giảm dần
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get(); 
        return view('admin.orders.index', compact('orders'));
    }
    
    // Hiển thị form chỉnh sửa đơn hàng
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled', // Kiểm tra giá trị status
        ]);
    
        // Tìm đơn hàng theo ID
        $order = Order::findOrFail($id);
        
        // Cập nhật trạng thái từ form
        $order->status = $request->input('status');
        $order->save();
    
        return redirect()->route('admin.orders.index')->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }
    
}
