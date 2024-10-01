@extends('cart.app')

@section('title', 'Thông Tin Thanh Toán')

@section('content')
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
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
            text-align: left;
        }

        .table img {
            max-width: 100px;
        }

        .total-row td {
            text-align: right;
            border: none; /* No border for total row */
        }

        .total-amount {
            font-weight: bold;
            color: #d9534f; /* Red color for total amount */
        }

        .address-form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }

        /* Button styles */
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-align: center;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background-color: #138496;
            transform: translateY(-2px);
        }

        .btn-back {
            background-color: #ffc107;
            color: white;
        }

        .btn-back:hover {
            background-color: #e0a800;
            transform: translateY(-2px);
        }

        /* Align buttons nicely */
        .btn-group {
            display: flex;
            justify-content: center;
            gap: 15px; /* Space between buttons */
            margin-top: 20px;
        }

        /* Media query for responsiveness */
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
        }
    </style>

    <div class="container">
        <h1>Thông Tin Thanh Toán</h1>

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
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2"><strong>Tổng Tiền:</strong></td>
                    <td class="total-amount">{{ number_format($grandTotal, 0, ',', '.') }} VNĐ</td>
                </tr>
           </tbody>
        </table>

        <h3 style="text-align: left; margin-top: 20px;">Địa Chỉ Giao Hàng:</h3>
        <form action="{{ route('payment.confirm') }}" method="POST" class="address-form" id="payment-form">
            @csrf
            <div class="form-group">
                <input type="text" name="shipping_address" id="shipping_address" class="form-control" placeholder="Nhập địa chỉ giao hàng" required>
            </div>

            <div class="form-group">
                <input type="text" name="phone" id="phone" class="form-control" placeholder="Nhập số điện thoại" required>
            </div>

            <h3 style="text-align: left; margin-top: 20px;">Phương Thức Thanh Toán:</h3>
            <div class="form-group payment-method">
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="" disabled selected>Chọn phương thức thanh toán</option>
                    <option value="cod">Nhận Hàng Khi Thanh Toán (COD)</option>
                </select>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-success">Xác Nhận Thanh Toán</button>
            </div>
        </form>

        <div class="btn-group">
            <button onclick="window.print()" class="btn btn-info">In Hóa Đơn</button>
            <a href="{{ route('cart.index') }}" class="btn btn-back">Quay Lại Giỏ Hàng</a>
        </div>
    </div>

    <!-- Thêm SweetAlert vào đây -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Ngăn chặn gửi form ngay lập tức

                swal({
                    title: "Xác Nhận Đơn Hàng",
                    text: "Bạn có chắc chắn muốn xác nhận đơn hàng này?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Có, xác nhận!",
                    cancelButtonText: "Không, quay lại!",
                    closeOnConfirm: false
                }, function(isConfirm) {
                    if (isConfirm) {
                        form.submit(); // Gửi form nếu người dùng xác nhận
                    }
                });
            });
        });
    </script>
@endsection
