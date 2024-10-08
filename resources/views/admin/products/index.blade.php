@extends('admin.admin')

@section('title', 'Manage Products')

@section('content')
    <style>
        /* CSS cho trang quản lý sản phẩm */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-title {
            font-size: 2rem;
            color: #007bff;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #007bff;
            border: 1px solid #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .list-group {
            margin-top: 20px;
            padding-left: 0;
            list-style: none;
        }

        .list-group-item {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            background-color: #fff;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }

        .list-group-item:hover {
            background-color: #f1f1f1;
        }

        .btn-warning {
            background-color: #ffc107;
            border: 1px solid #ffc107;
            color: #212529;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-danger {
            background-color: #dc3545;
            border: 1px solid #dc3545;
            color: #fff;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .product-info {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .product-info img {
            width: 100px;
            height: 100px;
            object-fit: cover; /* Đảm bảo hình ảnh không bị méo */
            margin-right: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .product-info .details {
            flex: 1;
        }

        .product-info .details h4 {
            margin: 0;
            font-size: 1.2rem;
            color: #333;
        }

        .product-info .details p {
            margin: 5px 0;
            color: #666;
        }
    </style>

    <div class="container">
        <h2 class="page-title">Product List</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Create New Product</a>

        <ul class="list-group">
            @forelse($products as $product)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="product-info">
                        <img src="{{ $product->image ? Storage::url($product->image) : asset('images/default-placeholder.png') }}" alt="{{ $product->name }}">
                        <div class="details">
                            <h4>{{ $product->name }}</h4>
                            <p>Category: {{ $product->category->name }}</p>
                            <p>Price: {{ number_format($product->price, 0, ',', '.') }} ₫</p> <!-- Hiển thị giá với định dạng VND -->
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="list-group-item">No products available.</li>
            @endforelse
        </ul>
    </div>
@endsection
