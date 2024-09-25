<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
{
    // Lấy thông tin sản phẩm từ giỏ hàng
    $items = $request->input('items');
    $shippingAddress = $request->input('shipping_address'); // Nhận địa chỉ giao hàng

    // Kiểm tra xem giỏ hàng có sản phẩm không
    if (empty($items)) {
        return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống. Vui lòng thêm sản phẩm để thanh toán.');
    }

    // Tính tổng tiền
    $grandTotal = 0;
    foreach ($items as $item) {
        $grandTotal += $item['price'] * $item['quantity'];
    }

    // Giả lập xử lý thanh toán
    $paymentSuccessful = true; // Giả lập thanh toán thành công

    if ($paymentSuccessful) {
        // Chuyển đến trang checkout.blade.php với thông tin cần thiết
        return view('checkout.checkout')->with([
            'items' => $items,
            'grandTotal' => $grandTotal,
            'shippingAddress' => $shippingAddress // Chuyển địa chỉ giao hàng
        ]);
    } else {
        return redirect()->route('cart.index')->with('error', 'Thanh toán thất bại. Vui lòng thử lại.');
    }
}

}
