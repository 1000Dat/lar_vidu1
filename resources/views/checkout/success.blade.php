@extends('layouts.app')

@section('title', 'Đặt Hàng Thành Công')

@section('content')
    <div class="container">
        <h1 class="text-center">Đặt Hàng Thành Công</h1>
        <p class="text-center">Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn sớm nhất.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Tiếp Tục Mua Sắm</a>
    </div>
@endsection
