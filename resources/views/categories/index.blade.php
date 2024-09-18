<!-- resources/views/categories/index.blade.php -->
@extends('categories.app')

@section('title', 'Categories')

@section('content')
    <style>
        /* CSS cho trang danh sách danh mục */
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

        .btn {
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            padding: 6px 12px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-warning {
            background-color: #ffc107;
            border: 1px solid #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-danger {
            background-color: #dc3545;
            border: 1px solid #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .auth-message {
            margin-top: 20px;
            font-size: 1rem;
            color: #343a40;
        }

        .auth-message a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        .auth-message a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="container">
        <h1>Các hãng sản phẩm</h1>
        @auth
            <ul class="list-group">
                @foreach($categories as $category)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $category->name }}git add .

                        <!-- Bạn có thể bỏ comment các phần này nếu cần -->
                        <!-- <div>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div> -->
                    </li>
                @endforeach
            </ul>
        @else
            <p class="auth-message">Bạn cần <a href="{{ route('login') }}">đăng nhập</a> để xem các danh mục.</p>
        @endauth
    </div>
@endsection
