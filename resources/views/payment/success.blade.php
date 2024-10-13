@extends('layouts.app')

@section('title', 'Thanh Toán Thành Công')

@section('content')
    <div class="container">
        <h1>Thanh Toán Thành Công</h1>
        <p>Cảm ơn bạn đã mua hàng! Đơn hàng của bạn đã được thanh toán thành công.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Quay về Trang Chủ</a>
    </div>
@endsection
