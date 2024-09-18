@extends('products.app')

@section('title', 'Danh sách sản phẩm')

@section('content')
    <div class="container">
      
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0 text-primary">Chào mừng đến với trang  </h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger shadow">Đăng xuất</button>
            </form>
        </div>
        <!-- Hiển thị sản phẩm -->
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ $product->image ? Storage::url($product->image) : asset('images/default-placeholder.png') }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text"><strong>Mô tả:</strong> {{ $product->description }}</p>
                            <p class="card-text"><strong>Số lượng:</strong> {{ $product->quantity }}</p>
                            <p class="card-text"><strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} VND</p>
                            <div class="btn-group">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">Chi tiết</a>
                                <a href="#" class="btn btn-primary">Mua Ngay</a>
                                <a href="#" class="btn btn-secondary">Thêm vào Giỏ Hàng</a>
                                <form action="#" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">Yêu Thích</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .card-img-top {
            height: 200px;  /* Đặt chiều cao cố định cho ảnh */
            object-fit: cover;  /* Giữ tỷ lệ khung hình và cắt ảnh để phù hợp */
            width: 100%;  /* Đảm bảo ảnh rộng bằng toàn bộ thẻ */
        }

        .card-body {
            padding: 1rem;
        }

        .card-title {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .card-text {
            margin-bottom: 0.5rem;
        }

        .btn-group {
            display: flex;
            gap: 0.5rem;  /* Khoảng cách giữa các nút */
            flex-wrap: wrap;  /* Cho phép các nút xuống dòng nếu không đủ không gian */
        }

        .btn-group .btn {
            flex: 1;  /* Các nút sẽ có kích thước bằng nhau */
            text-align: center;  /* Căn giữa văn bản trong nút */
            font-size: 0.9em;
            padding: 0.5rem 1rem;
            margin: 0;  /* Loại bỏ khoảng cách ngoài nút */
            white-space: nowrap;  /* Ngăn chặn văn bản trong nút xuống dòng */
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }

        .btn-outline-danger {
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        .shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
