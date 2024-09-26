<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Người Dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10 p-5 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center text-gray-800">Thông Tin Người Dùng</h1>

        <div class="mt-5 flex flex-col items-center">
            <img src="https://via.placeholder.com/150" alt="User Avatar" class="rounded-full border-4 border-blue-500 mb-4">
            <h2 class="text-2xl font-semibold text-gray-700" id="user-name">Lâm Thành Đạt</h2>
            <p class="text-gray-600" id="user-email">lamthanhdat7747@gmail.com</p>
            <p class="text-gray-600" id="user-phone">0362800179</p>
            <p class="text-gray-600" id="user-address">Tổ 4 Tân Châu</p>
        </div>

        <div class="mt-6 space-x-4 flex justify-center">
            <a href="/edit-profile" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">Chỉnh Sửa Thông Tin</a>
            <a href="/order-history" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">Lịch Sử Mua Hàng</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    Đăng Xuất
                </button>
            </form>
        </div>
    </div>
</body>

</html>
