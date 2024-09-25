@extends('products.app')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container">
    <h1 class="mb-4">Giỏ hàng của bạn</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @php
        $cartItems = session('cart', []);
        $cartItemCount = count($cartItems);
        $grandTotal = 0; // Khởi tạo tổng giá trị giỏ hàng
    @endphp

    @if($cartItemCount > 0)
        <form action="{{ route('cart.update') }}" method="POST">
            @csrf
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                        <th>Tùy chọn</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $id => $details)
                        @php
                            // Tính tổng tiền của từng sản phẩm (giá * số lượng)
                            $totalPriceForItem = $details['price'] * $details['quantity'];
                            // Cộng tổng tiền sản phẩm này vào tổng số tiền giỏ hàng
                            $grandTotal += $totalPriceForItem;
                        @endphp
                        <tr data-id="{{ $id }}" class="cart-item">
                            <td>{{ $details['name'] }}</td>
                            <td>
                                <img src="{{ $details['image'] ? Storage::url($details['image']) : asset('images/default-placeholder.png') }}" alt="{{ $details['name'] }}" style="max-width: 100px;">
                            </td>
                            <td>
                                <input type="number" name="updates[{{ $id }}][quantity]" class="quantity-input" value="{{ $details['quantity'] }}" min="1" required>
                                <input type="hidden" name="updates[{{ $id }}][id]" value="{{ $id }}">
                            </td>
                            <td class="price">{{ number_format($details['price'], 0, ',', '.') }} VND</td>
                            <td class="total">{{ number_format($totalPriceForItem, 0, ',', '.') }} VND</td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="delete-form">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right">
                <h4><strong>Tổng tiền giỏ hàng: {{ number_format($grandTotal, 0, ',', '.') }} VND</strong></h4>
            </div>

            <div class="actions d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-secondary">Cập nhật giỏ hàng</button>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
                <a href="{{ route('cart.checkout') }}" class="btn btn-success">Thanh toán</a>
            </div>
        </form>

        <form action="{{ route('cart.clear') }}" method="POST" class="clear-cart-form mt-3">
            @csrf
            <button type="submit" class="btn btn-warning btn-sm">Làm trống giỏ hàng</button>
        </form>
    @else
        <p>Giỏ hàng của bạn đang trống.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
    @endif
</div>
@endsection
