<!-- resources/views/cart/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Đường dẫn đến file CSS -->
</head>
<body>
    <header>
        <nav>
            <!-- <a href="{{ route('cart.index') }}">Giỏ Hàng</a>
            <a href="{{ route('products.index') }}">Sản Phẩm</a> -->
        </nav>
    </header>

    <main>
        @yield('content') <!-- Nội dung sẽ được chèn vào đây -->
    </main>

    <footer>
        <p>Bản quyền © {{ date('Y') }}</p>
    </footer>

    <script>
        function confirmPayment() {
            return confirm("Bạn chắc chắn muốn thanh toán?");
        }
    </script>
</body>
</html>
