@extends('products.app')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container">
    <h1 class="mb-4">Giỏ hàng của bạn</h1>

    @if(session('cart') && count(session('cart')) > 0)
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
                    @foreach(session('cart') as $id => $details)
                        <tr data-id="{{ $id }}" class="cart-item">
                            <td>{{ $details['name'] }}</td>
                            <td>
                                <img src="{{ $details['image'] ? Storage::url($details['image']) : asset('images/default-placeholder.png') }}" class="img-fluid" alt="{{ $details['name'] }}" style="max-width: 100px; max-height: 100px;">
                            </td>
                            <td>
                                <input type="number" name="updates[{{ $id }}][quantity]" class="quantity-input" value="{{ $details['quantity'] }}" min="1" style="width: 60px;" required>
                                <input type="hidden" name="updates[{{ $id }}][id]" value="{{ $id }}">
                            </td>
                            <td class="price">{{ number_format($details['price'], 0, ',', '.') }} VND</td>
                            <td class="total">{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }} VND</td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-secondary">Cập nhật giỏ hàng</button>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
                <a href="{{ route('cart.checkout') }}" class="btn btn-success">Thanh toán</a>
            </div>
        </form>
    @else
        <p>Giỏ hàng của bạn đang trống.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
    @endif
</div>
@endsection
