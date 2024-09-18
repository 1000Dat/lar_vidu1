<!-- resources/views/categories/products.blade.php -->
@extends('categories.app')

@section('title', $category->name)

@section('content')
    <style>
        /* CSS cho trang danh sách sản phẩm của danh mục */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-size: 2rem;
            color: #007bff;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .list-group {
            margin-top: 20px;
        }

        .list-group-item {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            background-color: #fff;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .list-group-item:hover {
            background-color: #f1f1f1;
        }
    </style>

    <div class="container">
        <h1>Sản phẩm trong danh mục: {{ $category->name }}</h1>
        <ul class="list-group">
            @foreach($products as $product)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $product->name }} - {{ $product->price }} VND
                </li>
            @endforeach
        </ul>
    </div>
@endsection
