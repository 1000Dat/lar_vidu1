<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header {
            padding: 10px 0;
            border-bottom: 2px solid #007bff;
            margin-bottom: 20px;
        }

        h1 {
            color: #007bff;
            margin: 0;
            font-size: 2em;
            text-align: center;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav .links {
            display: flex;
        }

        nav .links a {
            color: #333;
            text-decoration: none;
            margin-right: 15px;
            font-size: 1em;
        }

        nav .links a:hover {
            color: #007bff;
            text-decoration: underline;
        }

        nav .logout form {
            display: inline;
        }

        nav .logout button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 1em;
            border-radius: 4px;
            cursor: pointer;
        }

        nav .logout button:hover {
            background-color: #0056b3;
        }

        main {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Admin Panel</h1>
            <nav>
                <div class="links">
                    <a href="{{ route('admin.categories') }}">Danh mục</a>
                    <a href="{{ route('admin.products') }}">Sản phẩm</a>
                    <a href="{{ route('admin.orders.index') }}">Đơn hàng</a> <!-- Thêm liên kết tới đơn hàng -->
                    <a href="{{ route('admin.reports') }}">Thống kê và báo cáo</a>

                </div>
                <div class="logout">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
