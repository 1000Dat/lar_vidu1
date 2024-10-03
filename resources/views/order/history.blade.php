@extends('products.app')

@section('title', 'Lịch sử Đơn Hàng')

@section('content')
    <div class="container">
        <h1 class="text-primary">Lịch sử Đơn Hàng</h1>

        <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">Quay lại Trang Sản Phẩm</a> {{-- Nút quay lại trang sản phẩm --}}

        @if($orders->isEmpty())
            <p>Không có đơn hàng nào.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($orders as $index => $order)
                    <tr>
                        <td>{{ $index + 1 }}</td> {{-- Hiển thị số thứ tự --}}
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>{{ number_format($order->total_price, 0, ',', '.') }} VND</td>
                        <td>
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
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info">Xem Chi Tiết</a>
                            {{-- Nút xóa chỉ hiển thị nếu trạng thái là pending --}}
                            @if($order->status === 'pending')
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">Hủy đơn hàng</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
