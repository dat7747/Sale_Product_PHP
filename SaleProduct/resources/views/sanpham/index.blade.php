@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-3xl font-bold mb-4">Quản lý sản phẩm</h1>
    
    <a href="{{ route('sanpham.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Thêm sản phẩm</a>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="table-auto w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2">Tên sản phẩm</th>
                <th class="px-4 py-2">Loại sản phẩm</th>
                <th class="px-4 py-2">Giá</th>
                <th class="px-4 py-2">Thương hiệu</th>
                <th class="px-4 py-2">Ngày sản xuất</th>
                <th class="px-4 py-2">Bảo hành</th>
                <th class="px-4 py-2">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sanphams as $sanpham)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $sanpham->TenSanPham }}</td>
                    <td class="px-4 py-2">{{ $sanpham->loaiSanPham->TenLoaiSanPham }}</td>
                    <td class="px-4 py-2">{{ $sanpham->Gia }}</td>
                    <td class="px-4 py-2">{{ $sanpham->ThuongHieu }}</td>
                    <td class="px-4 py-2">{{ $sanpham->NgaySanXuat }}</td>
                    <td class="px-4 py-2">{{ $sanpham->BaoHanh }} tháng</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('sanpham.edit', $sanpham->id) }}" class="text-blue-500">Sửa</a>
                        <form action="{{ route('sanpham.destroy', $sanpham->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 ml-2">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
