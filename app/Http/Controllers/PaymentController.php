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



}
