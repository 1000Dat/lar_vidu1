@extends('products.app')

@section('title', 'Giỏ hàng')

@section('content')
<style>
    .actions {
        display: flex;
        justify-content: space-between; /* Căn chỉnh nút đều */
        margin-top: 20px; /* Khoảng cách trên */
    }

    .actions form {
        flex: 1; /* Đảm bảo tất cả các form có chiều rộng bằng nhau */
        margin: 0 5px; /* Khoảng cách giữa các nút */
    }

    .actions button {
        width: 100%; /* Nút chiếm toàn bộ chiều rộng của khối chứa */
        min-width: 150px; /* Đặt chiều rộng tối thiểu cho nút */
    }

    .cart-item img {
        max-width: 100px; /* Đảm bảo hình ảnh không vượt quá 100px */
    }

    .table th, .table td {
        vertical-align: middle; /* Căn giữa nội dung trong bảng */
    }
</style>

<div class="container">
    <h1 class="mb-4">Giỏ hàng của bạn</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @php
        $cartItemCount = count($cartItems);
        $grandTotal = 0; // Khởi tạo tổng giá trị giỏ hàng
    @endphp

    @if($cartItemCount > 0)
        <form action="{{ route('cart.update') }}" method="POST" id="cart-form">
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
                    @foreach($cartItems as $item)
                        @php
                            // Tính tổng tiền của từng sản phẩm (giá * số lượng)
                            $totalPriceForItem = $item->price * $item->quantity;
                            // Cộng tổng tiền sản phẩm này vào tổng số tiền giỏ hàng
                            $grandTotal += $totalPriceForItem;
                        @endphp
                        <tr data-id="{{ $item->id }}" class="cart-item">
                            <td>{{ $item->product->name }}</td>
                            <td>
                                <img src="{{ $item->product->image ? Storage::url($item->product->image) : asset('images/default-placeholder.png') }}" alt="{{ $item->product->name }}">
                            </td>
                            <td>
                                <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="updates[{{ $item->id }}][id]" value="{{ $item->id }}">
                                    <input type="number" name="updates[{{ $item->id }}][quantity]" class="quantity-input" value="{{ $item->quantity }}" min="1" required 
                                           onchange="this.form.submit()"> <!-- Gửi form khi số lượng thay đổi -->
                                </form>
                            </td>
                            <td class="price">{{ number_format($item->price, 0, ',', '.') }} VND</td>
                            <td class="total">{{ number_format($totalPriceForItem, 0, ',', '.') }} VND</td>
                            <td>
                                <form action="{{ route('cart.remove', $item->product_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right">
                <h4><strong>Tổng tiền giỏ hàng: {{ number_format($grandTotal, 0, ',', '.') }} VND</strong></h4>
            </div>

            <div class="actions">
                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning">Làm trống giỏ hàng</button>
                </form>

                <form action="{{ route('products.index') }}" method="GET" class="d-inline">
                    <button type="submit" class="btn btn-primary">Tiếp tục mua sắm</button>
                </form>

                <form action="{{ route('payment.process') }}" method="POST" class="d-inline">
                    @csrf
                    @foreach($cartItems as $item)
                        <input type="hidden" name="items[{{ $item->id }}][id]" value="{{ $item->id }}">
                        <input type="hidden" name="items[{{ $item->id }}][name]" value="{{ $item->product->name }}">
                        <input type="hidden" name="items[{{ $item->id }}][quantity]" value="{{ $item->quantity }}">
                        <input type="hidden" name="items[{{ $item->id }}][price]" value="{{ $item->price }}">
                    @endforeach
                    <button type="submit" class="btn btn-success">Thanh toán</button>
                </form>
            </div>
        </form>
    @else
        <p>Giỏ hàng của bạn đang trống.</p>
        <form action="{{ route('products.index') }}" method="GET" class="d-inline">
            <button type="submit" class="btn btn-primary">Tiếp tục mua sắm</button>
        </form>
    @endif
</div>
@endsection
