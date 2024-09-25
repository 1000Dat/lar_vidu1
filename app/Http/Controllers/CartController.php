<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function viewCart()
    {
        $cartItems = session()->get('cart', []);
        \Log::info('Cart Items:', $cartItems);
    
        return view('cart.index', compact('cartItems'));
    }
    
    // Thêm sản phẩm vào giỏ hàng
    public function add(Request $request, $id)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Sản phẩm không tồn tại!');
        }
    
        $cart = session()->get('cart', []);
    
        // Cập nhật giỏ hàng
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image,
            ];
        }
    
        session()->put('cart', $cart);
    
        return redirect()->route('cart.view')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }
    public function update(Request $request)
    {
        $updates = $request->input('updates', []);
        $cart = session()->get('cart', []);
    
        foreach ($updates as $update) {
            $id = $update['id'];
            $quantity = $update['quantity'];
    
            if (isset($cart[$id])) {
                if ($quantity <= 0) {
                    unset($cart[$id]); // Xóa sản phẩm nếu số lượng <= 0
                } else {
                    $cart[$id]['quantity'] = $quantity; // Cập nhật số lượng
                }
            }
        }
    
        session()->put('cart', $cart);
        
        // Trả về một thông điệp đơn giản
        return redirect()->back()->with('message', 'Giỏ hàng đã được cập nhật!');
    }
    
    
    // Xóa sản phẩm khỏi giỏ hàng
// CartController.php
public function remove($id)
{
    // Debug: Kiểm tra giỏ hàng trước khi xóa
    \Log::info('Giỏ hàng trước khi xóa: ', session()->get('cart'));

    $cart = session()->get('cart');

    // Check if the item exists in the cart
    if (isset($cart[$id])) {
        unset($cart[$id]); // Remove the item completely
        session()->put('cart', $cart); // Update the session

        // Debug: Kiểm tra giỏ hàng sau khi xóa
        \Log::info('Giỏ hàng sau khi xóa: ', session()->get('cart'));

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }

    return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
}


    public function updateCart(Request $request)
{
    $user = auth()->user();
    $cart = Cart::where('user_id', $user->id)->first();

    if (!$cart) {
        return redirect()->route('cart.view')->with('error', 'Giỏ hàng không tồn tại.');
    }

    foreach ($request->input('updates') as $update) {
        $cartItem = CartItem::where('cart_id', $cart->id)
                             ->where('product_id', $update['id'])
                             ->first();

        if ($cartItem) {
            // Cập nhật số lượng
            $cartItem->quantity = $update['quantity'];
            $cartItem->save();
        }
    }

    // Tính toán lại tổng giá của giỏ hàng
    $this->updateCartTotal($cart);

    // Redirect về giỏ hàng với thông báo thành công
    return redirect()->route('cart.view')->with('success', 'Giỏ hàng đã được cập nhật thành công!');
}


public function clear()
{
    // Xóa toàn bộ giỏ hàng từ session
    session()->forget('cart');
    
    // Chuyển hướng về trang giỏ hàng với thông báo thành công
    return redirect()->route('cart.view')->with('success', 'Giỏ hàng đã được làm trống!');
}

    
} 