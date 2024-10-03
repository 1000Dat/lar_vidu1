@extends('admin.admin') <!-- Hoặc layout của bạn -->

@section('title', 'Danh Sách Đơn Hàng')

@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
        }

        .alert {
            padding: 10px;
            background-color: #d4edda;
            color: #155724;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }

        .input-group {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .input-group input {
            flex: 1; /* Make input take up available space */
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px 0 0 4px;
        }

        .input-group button {
            padding: 10px 20px;
            border: none;
            border-radius: 0 4px 4px 0;
            color: white;
            background-color: #007bff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .input-group button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }

        .payment-method {
            text-align: center;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* CSS cho trạng thái đơn hàng */
        .status-pending {
            color: #ffc107; /* Vàng cho trạng thái 'Chờ xử lý' */
            font-weight: bold;
        }

        .status-processing {
            color: #007bff; /* Xanh dương cho trạng thái 'Đang xử lý' */
            font-weight: bold;
        }

        .status-completed {
            color: #28a745; /* Xanh lá cho trạng thái 'Hoàn thành' */
            font-weight: bold;
        }

        .status-cancelled {
            color: #dc3545; /* Đỏ cho trạng thái 'Đã hủy' */
            font-weight: bold;
        }

        .status-unknown {
            color: #6c757d; /* Xám cho trạng thái 'Không xác định' */
            font-weight: bold;
        }
    </style>

    <div class="container">
        <h2>Danh Sách Đơn Hàng</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Search Form -->
        <form action="{{ route('admin.orders.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên hoặc số điện thoại" value="{{ request()->input('search') }}">
                <button class="btn btn-primary" type="submit">Tìm Kiếm</button>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã Đơn Hàng</th>
                    <th>Tên Khách Hàng</th>
                    <th>Số Điện Thoại</th>
                    <th>Địa Chỉ Giao Hàng</th>
                    <th class="payment-method">Phương Thức Thanh Toán</th>
                    <th>Trạng Thái</th>
                    <th>Tổng Tiền</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->shipping_address }}</td>
                        <td class="payment-method">{{ $order->payment_method }}</td>
                        <td class="@switch($order->status)
                                        @case('pending')
                                            status-pending
                                            @break
                                        @case('processing')
                                            status-processing
                                            @break
                                        @case('completed')
                                            status-completed
                                            @break
                                        @case('cancelled')
                                            status-cancelled
                                            @break
                                        @default
                                            status-unknown
                                    @endswitch">
                            @switch($order->status)
                                @case('pending')
                                    Chờ xử lý
                                    @break
                                @case('processing')
                                    Đang xử lý
                                    @break
                                @case('completed')
                                    Hoàn thành
                                    @break
                                @case('cancelled')
                                    Đã hủy
                                    @break
                                @default
                                    Không xác định
                            @endswitch
                        </td>
                        <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                        <td>
                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn">Sửa</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
