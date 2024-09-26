@extends('cart.app')

@section('title', 'Thông Tin Thanh Toán')

@section('content')
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            color: #333;
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        .table img {
            max-width: 100px; /* Điều chỉnh kích thước hình ảnh */
            border-radius: 4px;
        }

        .total {
            color: #d9534f;
            font-weight: bold;
            font-size: 1.2em;
            text-align: right;
        }

        .address-form {
            margin-top: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-success {
            background-color: #5cb85c;
            color: white;
        }

        .btn-info {
            background-color: #5bc0de;
            color: white;
        }

        .btn-back {
            background-color: #f0ad4e; /* Màu sắc cho nút quay lại */
            color: white;
        }

        .payment-method {
            margin: 20px 0;
        }
    </style>

    <div class="container">
        <h1 class="text-center">Thông Tin Thanh Toán</h1>

        <h2>Chi Tiết Sản Phẩm:</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Tên Sản Phẩm</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ number_format($item['price'], 0, ',', '.') }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Tổng Tiền: <span class="total">{{ number_format($grandTotal, 0, ',', '.') }} VNĐ</span></h3>

        <h3>Địa Chỉ Giao Hàng:</h3>
        <form action="{{ route('payment.process') }}" method="POST" class="address-form">
            @csrf
            <div class="form-group">
                <input type="text" name="shipping_address" id="shipping_address" class="form-control" placeholder="Nhập địa chỉ giao hàng" required>
            </div>

            <!-- Phương Thức Thanh Toán -->
            <h3>Phương Thức Thanh Toán:</h3>
            <div class="form-group payment-method">
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="" disabled selected>Chọn phương thức thanh toán</option>
                    <option value="cod">Nhận Hàng Khi Thanh Toán (COD)</option>
                    <!-- <option value="online">Thanh Toán Online</option> -->
                </select>
            </div>

            <button type="submit" class="btn btn-success">Xác Nhận </button>
        </form>

        <button onclick="window.print()" class="btn btn-info">In Hóa Đơn</button>
        <a href="{{ route('cart.index') }}" class="btn btn-back">Quay Lại Giỏ Hàng</a> <!-- Nút quay lại giỏ hàng -->
    </div>
@endsection
`