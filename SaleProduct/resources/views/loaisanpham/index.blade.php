@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Quản Lý Loại Sản Phẩm</h1>
    
    <!-- Thêm loại sản phẩm -->
    <form action="{{ isset($loaisanpham) ? route('loaisanpham.update', $loaisanpham->LoaiSanPhamID) : route('loaisanpham.store') }}" method="POST" class="mb-6 bg-white p-4 rounded-lg shadow-md transition-transform duration-300 transform hover:scale-105">
        @csrf
        @if(isset($loaisanpham))
            @method('PUT')
        @endif
        <div class="mb-4">
            <label for="TenLoaiSanPham" class="block text-sm font-medium text-gray-700">Tên Loại Sản Phẩm</label>
            <input type="text" name="TenLoaiSanPham" id="TenLoaiSanPham" value="{{ isset($loaisanpham) ? $loaisanpham->TenLoaiSanPham : '' }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
            @error('TenLoaiSanPham')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded transition-colors duration-300 hover:bg-blue-600">{{ isset($loaisanpham) ? 'Cập Nhật' : 'Thêm' }}</button>
    </form>

    <h2 class="text-xl font-semibold mt-6">Danh Sách Loại Sản Phẩm</h2>
    <table class="min-w-full mt-4 bg-white rounded-lg shadow-md">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">#</th>
                <th class="px-4 py-2 text-left">Tên Loại Sản Phẩm</th>
                <th class="px-4 py-2 text-left">Hành Động</th>
            </tr>
        </thead>
        <tbody>
        @foreach($loaisanphams as $loai)
            <tr class="hover:bg-gray-100 transition-colors duration-200">
                <td class="border px-4 py-2">{{ $loai->LoaiSanPhamID }}</td>
                <td class="border px-4 py-2">{{ $loai->TenLoaiSanPham }}</td>
                <td class="border px-4 py-2">
                    <!-- Thêm link edit -->
                    <a href="{{ route('loaisanpham.edit', $loai->LoaiSanPhamID) }}" class="text-blue-600 hover:text-blue-900 transition-colors duration-300">Sửa</a>
                    <form action="{{ route('loaisanpham.destroy', $loai->LoaiSanPhamID) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 transition-colors duration-300">Xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
