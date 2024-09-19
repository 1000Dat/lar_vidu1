@extends('products.app') <!-- Đảm bảo bạn có layout app.blade.php trong resources/views/layouts -->

@section('title', 'Giỏ hàng')

@section('content')
<div class="container">
    <h1 class="mb-4">Giỏ hàng của bạn</h1>

    @php
        $cartItems = session('cart', []);
        $cartItemCount = count($cartItems);
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
                        <tr data-id="{{ $id }}" class="cart-item">
                            <td>{{ $details['name'] }}</td>
                            <td>
                                <img src="{{ $details['image'] ? Storage::url($details['image']) : asset('images/default-placeholder.png') }}" alt="{{ $details['name'] }}">
                            </td>
                            <td>
                                <input type="number" name="updates[{{ $id }}][quantity]" class="quantity-input" value="{{ $details['quantity'] }}" min="1" required>
                                <input type="hidden" name="updates[{{ $id }}][id]" value="{{ $id }}">
                            </td>
                            <td class="price">{{ number_format($details['price'], 0, ',', '.') }} VND</td>
                            <td class="total">{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }} VND</td>
                            <td>
                                @if($cartItemCount > 1)
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="delete-form">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="actions d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-secondary">Cập nhật giỏ hàng</button>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
                <a href="{{ route('cart.checkout') }}" class="btn btn-success">Thanh toán</a>
            </div>
        </form>

        <!-- Nút "Làm trống giỏ hàng" chỉ hiển thị khi có sản phẩm trong giỏ hàng -->
        <form action="{{ route('cart.clear') }}" method="POST" class="clear-cart-form mt-3">
            @csrf
            <button type="submit" class="btn btn-warning btn-sm">Làm trống giỏ hàng</button>
        </form>
    @else
        <p>Giỏ hàng của bạn đang trống.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
    @endif
</div>

<!-- CSS -->
<style>
    /* CSS chung cho giỏ hàng */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        table-layout: fixed; /* Giúp bảng ổn định hơn khi căn chỉnh */
    }

    .table th, .table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .table th {
        background-color: #f8f9fa;
        text-align: right; /* Căn chỉnh tiêu đề bảng lệch qua phải */
    }

    .table img {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
    }

    .quantity-input {
        width: 60px;
        text-align: center;
    }

    .price, .total {
        text-align: right;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .actions, .clear-cart-form {
        margin-top: 20px;
    }

    .clear-cart-form {
        display: inline-block;
    }
</style>
@endsection
