@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-3xl font-bold text-center mb-6">Thêm Sản Phẩm Mới</h1>

    <form action="{{ route('sanpham.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        <div class="mb-4">
            <label for="TenSanPham" class="block text-lg font-medium mb-2">Tên sản phẩm:</label>
            <input type="text" name="TenSanPham" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="LoaiSanPhamID" class="block text-lg font-medium mb-2">Loại sản phẩm:</label>
            <select name="LoaiSanPhamID" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:ring-blue-500" required>
                @foreach($loaiSanPhams as $loaiSanPham)
                    <option value="{{ $loaiSanPham->LoaiSanPhamID }}">{{ $loaiSanPham->TenLoaiSanPham }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="Gia" class="block text-lg font-medium mb-2">Giá:</label>
            <input type="text" name="Gia" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="ThuongHieu" class="block text-lg font-medium mb-2">Thương hiệu:</label>
            <input type="text" name="ThuongHieu" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="NgaySanXuat" class="block text-lg font-medium mb-2">Ngày sản xuất:</label>
            <input type="date" name="NgaySanXuat" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="BaoHanh" class="block text-lg font-medium mb-2">Bảo hành (tháng):</label>
            <input type="number" name="BaoHanh" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="HinhAnh" class="block text-lg font-medium mb-2">Hình ảnh:</label>
            <input type="file" name="HinhAnh" class="w-full border border-gray-300 rounded px-4 py-2">
        </div>

        <div class="mb-4">
            <label for="Mota" class="block text-lg font-medium mb-2">Mô tả:</label>
            <textarea name="Mota" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:ring-blue-500" rows="4"></textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 transition duration-300">Thêm sản phẩm</button>
    </form>
</div>
@endsection
