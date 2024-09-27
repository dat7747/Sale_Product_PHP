<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Loại Sản Phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="antialiased bg-gray-100">
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-6">Chỉnh Sửa Loại Sản Phẩm</h1>
        <form action="{{ route('loaisanpham.update', ['loaisanpham' => $loaiSanPham->LoaiSanPhamID]) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md transition-transform duration-300 transform hover:scale-105">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="TenLoaiSanPham" class="block text-sm font-medium text-gray-700">Tên Loại Sản Phẩm</label>
                <input type="text" name="TenLoaiSanPham" id="TenLoaiSanPham" value="{{ $loaiSanPham->TenLoaiSanPham }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                @error('TenLoaiSanPham')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded transition-colors duration-300 hover:bg-blue-600">Cập Nhật</button>
            <a href="{{ route('loaisanpham.index') }}" class="ml-4 text-gray-600 hover:underline transition-colors duration-300">Trở Về</a>
        </form>
    </div>
</body>
</html>
