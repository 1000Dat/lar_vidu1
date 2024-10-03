@extends('admin.admin') <!-- Hoặc layout của bạn -->

@section('title', 'Chỉnh Sửa Đơn Hàng')

@section('content')
    <style>
        body {
            background-color: #f4f4f4; /* Màu nền tổng thể */
            font-family: Arial, sans-serif; /* Font chữ */
        }

        .container {
            max-width: 800px;
            margin: 30px auto; /* Căn giữa */
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }

        h3 {
            text-align: center;
            margin-top: 30px;
            font-size: 24px;
            color: #555;
        }

        .alert {
            background-color: #dff0d8; /* Màu nền cho thông báo thành công */
            color: #3c763d; /* Màu chữ */
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .order-details .form-group {
            margin-bottom: 20px;
        }

        .order-details label {
            font-weight: bold;
            margin-bottom: 5px; /* Khoảng cách giữa label và input */
        }

        .form-control {
            width: 100%;
            padding: 12px; /* Padding cho ô input */
            border: 1px solid #ddd;
            border-radius: 5px; /* Bo tròn các góc */
            box-sizing: border-box; /* Đảm bảo padding không làm tăng kích thước tổng thể */
            transition: border-color 0.3s; /* Hiệu ứng chuyển tiếp cho border */
        }

        .form-control:focus {
            border-color: #007bff; /* Màu border khi focus */
            outline: none; /* Bỏ outline mặc định */
        }

        .table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            background-color: #f9f9f9; /* Màu nền cho bảng */
            border-radius: 5px; /* Bo tròn các góc */
            overflow: hidden; /* Để bo tròn góc của bảng */
        }

        .table th, .table td {
            text-align: center;
            padding: 12px; /* Padding cho các ô trong bảng */
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #007bff; /* Màu nền cho header bảng */
            color: white; /* Màu chữ */
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s; /* Hiệu ứng chuyển tiếp cho nút */
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Màu nền khi hover */
        }
    </style>

    <div class="container">
        <h2>Chỉnh Sửa Đơn Hàng #{{ $order->id }}</h2>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <!-- Hiển thị toàn bộ thông tin đơn hàng -->
        <div class="order-details">
            <div class="form-group">
                <label for="customer_name">Tên Khách Hàng:</label>
                <input type="text" id="customer_name" class="form-control" value="{{ $order->user->name }}" readonly>
            </div>

            <div class="form-group">
                <label for="phone">Số Điện Thoại:</label>
                <input type="text" id="phone" class="form-control" value="{{ $order->phone }}" readonly>
            </div>

            <div class="form-group">
                <label for="address">Địa Chỉ Giao Hàng:</label>
                <input type="text" id="address" class="form-control" value="{{ $order->shipping_address }}" readonly>
            </div>

            <div class="form-group">
                <label for="payment_method">Phương Thức Thanh Toán:</label>
                <input type="text" id="payment_method" class="form-control" value="{{ $order->payment_method }}" readonly>
            </div>

            <div class="form-group">
                <label for="total_price">Tổng Tiền:</label>
                <input type="text" id="total_price" class="form-control" value="{{ number_format($order->total_price, 0, ',', '.') }} VNĐ" readonly>
            </div>
        </div>

        <!-- Hiển thị danh sách sản phẩm trong đơn hàng -->
        <h3>Sản Phẩm Trong Đơn Hàng</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Tên Sản Phẩm</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Form chỉnh sửa trạng thái đơn hàng -->
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="status">Trạng Thái:</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
@endsection
