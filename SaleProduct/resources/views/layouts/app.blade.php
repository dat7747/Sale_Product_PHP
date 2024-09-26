<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cửa Hàng Điện Tử')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        /* Hiệu ứng hover cho menu con */
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>
<body class="antialiased bg-gray-100">
    <!-- Header -->
    <header class="bg-gray-800 text-white py-4">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-4xl font-bold">Cửa Hàng Điện Tử</h1>
            <nav>
                <ul class="flex space-x-4 items-center">
                    <li><a href="/" class="hover:text-yellow-500 transition">Trang Chủ</a></li>

                    <!-- Dropdown Sản Phẩm -->
                    <li class="relative dropdown">
                        <a href="#" class="hover:text-yellow-500 transition">Sản Phẩm</a>
                        <ul class="dropdown-menu absolute hidden bg-white text-gray-800 shadow-lg rounded-lg mt-2 py-2">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Điện Thoại</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Máy Giặt</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Tủ Lạnh</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Laptop</a></li>
                        </ul>
                    </li>

                    <li><a href="#" class="hover:text-yellow-500 transition">Liên Hệ</a></li>

                    <!-- Nút Đăng Nhập & Đăng Ký -->
                    <li><a href="/login" class="hover:text-yellow-500 transition">Đăng Nhập</a></li>
                    <li><a href="/register" class="hover:text-yellow-500 transition">Đăng Ký</a></li>

                    <!-- Icon Giỏ Hàng -->
                    <li>
                        <a href="#" class="relative">
                            <i class="fas fa-shopping-cart text-white text-2xl"></i>
                            <!-- Số lượng sản phẩm trong giỏ -->
                            <span class="absolute top-0 right-0 transform translate-x-1 -translate-y-1 inline-block w-4 h-4 bg-red-500 text-white text-xs font-bold rounded-full text-center">0</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-10">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Cửa Hàng Điện Tử. Tất cả các quyền được bảo lưu.</p>
        </div>
    </footer>
</body>
</html>
