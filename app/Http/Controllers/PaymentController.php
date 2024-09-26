<?php
namespace App\Http\Controllers;
use App\Models\Product; // Thêm dòng này
use Illuminate\Http\Request;
use App\Models\Order; // Đảm bảo đã import Order model
use App\Models\OrderItem; // Đảm bảo đã import OrderItem model
use Illuminate\Support\Facades\Auth;


use App\Models\Cart; // Thêm dòng import cho Cart model
use App\Models\CartItem; // Thêm dòng import cho CartItem model


class PaymentController extends Controller
{

    public function processPayment(Request $request)
{
    // Lấy người dùng hiện tại
    $user = Auth::user();

    // Lấy tất cả các sản phẩm trong giỏ hàng của người dùng từ bảng CartItem
    $cartItems = CartItem::whereHas('cart', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })->get();

    // Kiểm tra nếu giỏ hàng trống
    if ($cartItems->isEmpty()) {
        return redirect()->route('products.index')->with('error', 'Giỏ hàng của bạn đang trống.');
    }

    // Tính tổng tiền cho giỏ hàng
    $grandTotal = $cartItems->sum(function($item) {
        return $item->price * $item->quantity;
    });

    // Trả về view checkout với dữ liệu sản phẩm
    return view('checkout.checkout', compact('cartItems', 'grandTotal'));
}



public function confirm(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'shipping_address' => 'required|string|max:255',
        'payment_method' => 'required|string',
    ]);

    // Lấy người dùng hiện tại
    $user = Auth::user();

    // Lấy tất cả các sản phẩm trong giỏ hàng của người dùng
    $cartItems = CartItem::whereHas('cart', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })->get();

    // Kiểm tra nếu giỏ hàng trống
    if ($cartItems->isEmpty()) {
        return redirect()->route('products.index')->with('error', 'Giỏ hàng của bạn đang trống.');
    }

    // Tạo đơn hàng
    $order = new Order();
    $order->user_id = $user->id;
    $order->shipping_address = $request->input('shipping_address');
    $order->payment_method = $request->input('payment_method');

    // Khởi tạo tổng tiền
    $grandTotal = $cartItems->sum(function($item) {
        return $item->price * $item->quantity;
    });
    $order->total_price = $grandTotal;
    $order->save();

    // Tạo các mục đơn hàng
    foreach ($cartItems as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->price,
        ]);
    }

    // Xóa giỏ hàng sau khi đặt hàng
    CartItem::whereHas('cart', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })->delete();

    // Chuyển hướng đến trang xác nhận
    return redirect()->route('products.index');
}

}
