<!-- resources/views/home.blade.php -->

@extends('products.app')

@section('title', 'Trang Chính')

@section('content')
    <style>
        .home-container {
            background-color: #fff;
            color: #333;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .home-heading {
            color: #007bff;
        }

        .home-subheading {
            color: #343a40;
        }

        .home-btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            padding: 12px 24px;
            border-radius: 5px;
            text-decoration: none;
        }

        .home-btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
            padding: 12px 24px;
            border-radius: 5px;
            text-decoration: none;
        }

        .home-btn-primary:hover,
        .home-btn-secondary:hover {
            opacity: 0.9;
        }

        .logout-btn {
            background-color: #dc3545;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .user-info {
            margin-bottom: 20px;
            color: #6c757d;
        }
    </style>

    <div class="container home-container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-3 mb-4 home-heading">Chào Mừng!</h1>
                <p class="lead mb-4">Chúng tôi rất vui được chào đón bạn đến với trang chính của chúng tôi.</p>
                <p class="mb-4">Trang này yêu cầu bạn phải đăng nhập. Dựa trên vai trò của bạn, bạn sẽ được chuyển hướng đến trang phù hợp.</p>

                @if (Auth::check())
                    <div class="user-info">
                        <p>Xin chào, {{ Auth::user()->name }}!</p>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="logout-btn">Đăng Xuất</button>
                        </form>
                    </div>

                    <div class="mt-5">
                        @if (Auth::user()->role == 'admin')
                            <h2 class="display-4 mb-4 home-subheading">Quản Lý Hệ Thống</h2>
                            <p class="lead mb-4">Dưới đây là các công cụ quản lý dành cho quản trị viên:</p>
                            <a href="{{ route('admin.dashboard') }}" class="home-btn-primary mb-2">Bảng Điều Khiển</a>
                            <a href="{{ route('admin.categories') }}" class="home-btn-secondary mb-2">Quản Lý Danh Mục</a>
                            <a href="{{ route('admin.products') }}" class="home-btn-secondary mb-2">Quản Lý Sản Phẩm</a>
                        @else
                            <h2 class="display-4 mb-4 home-subheading">Khám Phá Sản Phẩm</h2>
                            <p class="lead mb-4">Dưới đây là các công cụ dành cho bạn:</p>
                            <a href="{{ route('products.index') }}" class="home-btn-primary mb-2">Danh Sách Sản Phẩm</a>
                            <a href="{{ route('categories.index') }}" class="home-btn-secondary mb-2">Danh Sách Danh Mục</a>
                        @endif
                    </div>
                @else
                    <div class="mt-5">
                        <p class="lead mb-4">Vui lòng đăng nhập để truy cập nội dung đầy đủ.</p>
                        <a href="{{ route('login') }}" class="home-btn-primary">Đăng Nhập</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
