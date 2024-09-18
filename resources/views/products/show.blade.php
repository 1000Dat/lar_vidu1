<!-- resources/views/products/show.blade.php -->

@extends('products.app')

@section('title', 'Chi Tiết Sản Phẩm')

@section('content')
    <div class="container">
        <h1>{{ $product->name }}</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Danh Mục: {{ $product->category->name }}</h5>
                <p class="card-text">Mô Tả: {{ $product->description }}</p>
                <p class="card-text">Số Lượng: {{ $product->quantity }}</p>
                <p class="card-text">Giá: {{ number_format($product->price, 2) }} VND</p>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Trở Về</a>
            </div>
        </div>
    </div>
@endsection
