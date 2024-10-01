<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    // Query to fetch orders, with filtering based on search
    $orders = Order::when($search, function ($query, $search) {
            return $query->where(function($query) use ($search) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })->orWhere('phone', 'like', '%' . $search . '%');
            });
        })
        ->with('user') // Eager load the user relationship to avoid N+1 query problem
        ->orderByRaw("CASE status 
                            WHEN 'pending' THEN 1 
                            WHEN 'processing' THEN 2 
                            WHEN 'completed' THEN 3 
                            WHEN 'cancelled' THEN 4 
                            ELSE 5 
                        END") // Order by status with pending first
        ->get();

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
