@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Thêm sản phẩm mới</h1>

    <form action="{{ route('sanpham.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="TenSanPham" class="block">Tên sản phẩm:</label>
            <input type="text" name="TenSanPham" class="w-full border px-4 py-2" required>
        </div>

        <div class="mb-4">
            <label for="LoaiSanPhamID" class="block">Loại sản phẩm:</label>
            <select name="LoaiSanPhamID" class="w-full border px-4 py-2" required>
                @foreach($loaiSanPhams as $loaiSanPham)
                    <option value="{{ $loaiSanPham->id }}">{{ $loaiSanPham->TenLoaiSanPham }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="Gia" class="block">Giá:</label>
            <input type="text" name="Gia" class="w-full border px-4 py-2" required>
        </div>

        <div class="mb-4">
            <label for="ThuongHieu" class="block">Thương hiệu:</label>
            <input type="text" name="ThuongHieu" class="w-full border px-4 py-2" required>
        </div>

        <div class="mb-4">
            <label for="NgaySanXuat" class="block">Ngày sản xuất:</label>
            <input type="date" name="NgaySanXuat" class="w-full border px-4 py-2" required>
        </div>

        <div class="mb-4">
            <label for="BaoHanh" class="block">Bảo hành (tháng):</label>
            <input type="number" name="BaoHanh" class="w-full border px-4 py-2" required>
        </div>

        <div class="mb-4">
            <label for="HinhAnh" class="block">Hình ảnh:</label>
            <input type="file" name="HinhAnh" class="w-full">
        </div>

        <div class="mb-4">
            <label for="Mota" class="block">Mô tả:</label>
            <textarea name="Mota" class="w-full border px-4 py-2"></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Thêm sản phẩm</button>
    </form>
</div>
@endsection
