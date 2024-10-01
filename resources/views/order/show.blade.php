@extends('products.app')

@section('title', 'Chi Tiết Đơn Hàng')

@section('content')
    <div class="container">
        <!-- Title: Order Details -->
        <h1 class="mb-4 text-primary">Chi Tiết Đơn Hàng #{{ $order->id }}</h1>

        <!-- Order Information Card -->
        <div class="card mb-4">
            <div class="card-body">
                <!-- Order Information -->
                <h5 class="card-title"><strong>Thông Tin Đơn Hàng</strong></h5>
                <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p> <!-- Thêm số điện thoại -->
                <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method }}</p>
                <p><strong>Tổng giá:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VND</p>
                <p><strong>Trạng thái:</strong> 
                    <span class="@switch($order->status)
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
                    </span>
                </p>
            </div>
        </div>

        <!-- Product List -->
        <h3 class="mb-3">Danh sách sản phẩm</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Check if the order has items -->
                    @if($order->orderItems->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center">Không có sản phẩm nào trong đơn hàng này.</td>
                        </tr>
                    @else
                        <!-- Loop through each order item -->
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td>{{ optional($item->product)->name ?? 'N/A' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }} VND</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Buttons: Back to Order List and Cancel Order if Pending -->
        <div class="d-flex justify-content-between mt-4">
            <!-- Button to go back to the orders list -->
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>

            <!-- Cancel Order Button (only appears if order status is 'pending') -->
            @if($order->status === 'pending')
                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">Hủy Đơn Hàng</button>
                </form>
            @endif
        </div>
    </div>

    <style>
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
@endsection
