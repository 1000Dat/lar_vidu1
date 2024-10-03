@extends('admin.admin')

@section('title', 'Thống Kê và Báo Cáo')

@section('content')
    <div class="report-container">
        <h2>Thống Kê và Báo Cáo</h2>

        <div class="report-section">
            <h3>Tổng Quan</h3>
            <ul>
                <li>Tổng số đơn hàng: {{ $totalOrders }}</li>
                <li>Tổng số sản phẩm: {{ $totalProducts }}</li>
                <li>Tổng doanh thu: {{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</li>
            </ul>
        </div>

        <div class="report-section">
            <h3>Doanh Thu Theo Ngày</h3>
            <table>
                <thead>
                    <tr>
                        <th>Ngày</th>
                        <th>Doanh Thu</th>
                        <th>Số Đơn Hàng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailySales as $sale)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}</td>
                            <td>{{ number_format($sale->daily_revenue, 0, ',', '.') }} VNĐ</td>
                            <td>{{ $sale->total_orders }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="report-section">
            <h3>Sản Phẩm Bán Trong 1 Tháng</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tên Sản Phẩm</th>
                        <th>Số Lượng Đã Bán</th>
                        <th>Số Lượng Còn Lại</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productsSoldLastMonth as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sold_quantity }}</td>
                            <td>{{ $product->remaining_stock }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

       

    </div>

    <style>
        .report-container {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        h2, h3 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
            font-size: 1.2em;
        }

        .report-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }
    </style>
@endsection
