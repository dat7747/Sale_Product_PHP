@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-4xl font-bold mb-6 text-center text-gray-800">Sửa sản phẩm</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sanpham.update', $sanpham->SanPhamID) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Tên sản phẩm:</label>
            <input type="text" name="TenSanPham" value="{{ $sanpham->TenSanPham }}" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Loại sản phẩm:</label>
            <select name="LoaiSanPhamID" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" required>
                @foreach($loaiSanPhams as $loaiSanPham)
                    <option value="{{ $loaiSanPham->LoaiSanPhamID }}" {{ $loaiSanPham->LoaiSanPhamID == $sanpham->LoaiSanPhamID ? 'selected' : '' }}>
                        {{ $loaiSanPham->TenLoaiSanPham }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Giá:</label>
            <input type="number" name="Gia" value="{{ $sanpham->Gia }}" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Thương hiệu:</label>
            <input type="text" name="ThuongHieu" value="{{ $sanpham->ThuongHieu }}" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Ngày sản xuất:</label>
            <input type="date" name="NgaySanXuat" value="{{ $sanpham->NgaySanXuat }}" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Bảo hành (tháng):</label>
            <input type="number" name="BaoHanh" value="{{ $sanpham->BaoHanh }}" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Hình ảnh:</label>
            <input type="file" name="HinhAnh" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Cập nhật sản phẩm</button>
    </form>
</div>
@endsection
