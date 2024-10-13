@extends('layouts.app')

@section('title', 'Thanh Toán Thất Bại')

@section('content')
    <div class="container">
        <h1>Thanh Toán Thất Bại</h1>
        <p>Rất tiếc, quá trình thanh toán đã gặp lỗi. Vui lòng thử lại sau.</p>
        <a href="{{ route('cart.index') }}" class="btn btn-primary">Quay Lại Giỏ Hàng</a>
    </div>
@endsection
