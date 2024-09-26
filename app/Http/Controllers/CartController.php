<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function viewCart()
    {
        // Kiểm tra người dùng đã đăng nhập
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem giỏ hàng.');
        }
    
        // Lấy giỏ hàng của người dùng
        $cart = Cart::where('user_id', $user->id)->with('items')->first();
    
        // Nếu giỏ hàng không tồn tại, khởi tạo mảng rỗng
        $cartItems = $cart ? $cart->items : collect(); // Sử dụng collect() để đảm bảo là Collection
    
        // Tính tổng giá của giỏ hàng
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price; // Tính tổng cho từng sản phẩm
        });
    
        // Kiểm tra và ghi log thông tin giỏ hàng
        Log::info('Cart Items:', $cartItems->toArray());
        Log::info('Total Amount:', ['total' => $totalAmount]);
    
        // Trả về view với danh sách sản phẩm trong giỏ hàng và tổng giá
        return view('cart.index', compact('cartItems', 'totalAmount'));
    }
    

    public function add(Request $request, $id)
    {
        // Tìm sản phẩm theo ID
        $product = Product::find($id);
    
        // Kiểm tra xem sản phẩm có tồn tại không
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Sản phẩm không tồn tại!');
        }
    
        // Lấy người dùng hiện tại
        $user = Auth::user();
    
        // Tìm hoặc tạo giỏ hàng cho người dùng
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
    
        // Tìm sản phẩm trong giỏ hàng, nếu có thì tăng số lượng
        $cartItem = CartItem::where('cart_id', $cart->id)
                             ->where('product_id', $id)
                             ->first();
    
        if ($cartItem) {
            // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
            $cartItem->quantity += 1;
            // Đảm bảo giá không thay đổi khi số lượng tăng
            // Không cần gọi save lại cho giá nếu đã có giá ban đầu
            $cartItem->save();
        } else {
            // Nếu chưa có sản phẩm trong giỏ hàng thì thêm mới
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $id,
                'quantity' => 1, // Mặc định số lượng là 1
                'price' => $product->price, // Lấy giá từ sản phẩm
            ]);
        }
    
        // Đảm bảo tên route chính xác
        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }
    
    // Xóa toàn bộ giỏ hàng
    public function clear()
    {
        // Lấy người dùng đang đăng nhập
        $user = auth()->user();
        
        // Lấy giỏ hàng của người dùng
        $cart = Cart::where('user_id', $user->id)->first();

        // Kiểm tra xem giỏ hàng có tồn tại không
        if ($cart) {
            // Xóa tất cả các mục trong giỏ hàng
            CartItem::where('cart_id', $cart->id)->delete();

            // Xóa giỏ hàng
            $cart->delete();

            // Chuyển hướng về trang giỏ hàng với thông báo thành công
            return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được làm trống!');
        }

        // Nếu giỏ hàng không tồn tại, chuyển hướng về trang giỏ hàng với thông báo
        return redirect()->route('cart.index')->with('error', 'Giỏ hàng hiện tại không có sản phẩm nào.');
    }

    // Cập nhật tổng giá của giỏ hàng
    protected function updateCartTotal(Cart $cart)
    {
        $total = CartItem::where('cart_id', $cart->id)->sum(DB::raw('quantity * price'));
        $cart->total = $total; // Giả sử bạn có một trường 'total' trong bảng Cart
        $cart->save();
    }

    public function removeItem(Request $request, $itemId)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
    
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng không tồn tại.');
        }
    
        // Tìm sản phẩm cần xóa trong bảng CartItem
        $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $itemId)->first();
    
        if ($cartItem) {
            // Xóa sản phẩm khỏi giỏ hàng
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
        }
    
        return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
    }
    
    public function update(Request $request)
{
    $updates = $request->input('updates');

    foreach ($updates as $update) {
        $cartItem = CartItem::find($update['id']);
        
        if ($cartItem) {
            // Update quantity in the database
            $cartItem->quantity = $update['quantity'];
            $cartItem->save();
        }
    }

    // Redirect back to the cart index with a success message
    return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật thành công.');
}

}
