@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-4xl font-bold mb-4 text-center text-gray-800 animate-bounce">Quản lý sản phẩm</h1>

    <!-- Thanh tìm kiếm -->
    <div class="flex justify-end mb-4">
        <input type="text" id="search" placeholder="Tìm kiếm sản phẩm..." class="w-1/3 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
    </div>

    <!-- Nút thêm sản phẩm -->
    <a href="{{ route('sanpham.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600 transition-all duration-300">Thêm sản phẩm</a>

    <!-- Thông báo thành công -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 mb-4 rounded-lg shadow-md animate-fadeIn">
            {{ session('success') }}
        </div>
    @endif

    <!-- Bảng sản phẩm -->
    <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
        <thead>
            <tr class="bg-gray-200 text-left text-sm uppercase font-semibold text-gray-600">
                <th class="px-4 py-3">Tên sản phẩm</th>
                <th class="px-4 py-3">Loại sản phẩm</th>
                <th class="px-4 py-3">Giá</th>
                <th class="px-4 py-3">Thương hiệu</th>
                <th class="px-4 py-3">Ngày sản xuất</th>
                <th class="px-4 py-3">Bảo hành</th>
                <th class="px-4 py-3 text-center">Hành động</th>
            </tr>
        </thead>
        <tbody id="productTable" class="text-sm">
            @foreach($sanphams as $sanpham)
                <tr class="border-b hover:bg-gray-100 transition duration-200">
                    <td class="px-4 py-2">{{ $sanpham->TenSanPham }}</td>
                    <td class="px-4 py-2">{{ $sanpham->loaiSanPham->TenLoaiSanPham }}</td>
                    <td class="px-4 py-2">{{ number_format($sanpham->Gia, 0, ',', '.') }} VND</td>
                    <td class="px-4 py-2">{{ $sanpham->ThuongHieu }}</td>
                    <td class="px-4 py-2">{{ $sanpham->NgaySanXuat }}</td>
                    <td class="px-4 py-2">{{ $sanpham->BaoHanh }} tháng</td>
                    <td class="px-4 py-2 text-center flex justify-center space-x-2">
                        <a href="{{ route('sanpham.edit', $sanpham->SanPhamID) }}" class="text-blue-600 hover:text-blue-800 transition">Sửa</a>
                        <form action="{{ route('sanpham.destroy', $sanpham->SanPhamID) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 transition">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Thêm CSS cho animation -->
<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fadeIn {
        animation: fadeIn 0.5s ease-in-out;
    }

    .animate-fadeInDown {
        animation: fadeInDown 0.5s ease-in-out;
    }
</style>

<script>
    document.getElementById('search').addEventListener('input', function() {
        const searchQuery = this.value;

        // Gửi yêu cầu AJAX tới server
        fetch(`/sanpham/search?query=${searchQuery}`)
            .then(response => {
                console.log('Response status:', response.status);
                
                // Kiểm tra xem phản hồi có phải là JSON không
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text); });
                }
                return response.json();
            })
            .then(data => {
                const tableBody = document.getElementById('productTable');
                tableBody.innerHTML = '';

                // Cập nhật bảng với các sản phẩm tìm thấy
                data.forEach(sanpham => {
                    const row = `
                        <tr class="border-b hover:bg-gray-100 transition duration-200">
                            <td class="px-4 py-2">${sanpham.TenSanPham}</td>
                            <td class="px-4 py-2">${sanpham.loaiSanPham?.TenLoaiSanPham || ''}</td>
                            <td class="px-4 py-2">${sanpham.Gia.toLocaleString('vi-VN')} VND</td>
                            <td class="px-4 py-2">${sanpham.ThuongHieu}</td>
                            <td class="px-4 py-2">${sanpham.NgaySanXuat}</td>
                            <td class="px-4 py-2">${sanpham.BaoHanh} tháng</td>
                            <td class="px-4 py-2 text-center flex justify-center space-x-2">
                                <a href="/sanpham/${sanpham.SanPhamID}/edit" class="text-blue-600 hover:text-blue-800 transition">Sửa</a>
                                <form action="/sanpham/${sanpham.SanPhamID}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
            })
            .catch(error => {
                console.error('Lỗi tìm kiếm:', error);
                alert('Có lỗi xảy ra. Vui lòng kiểm tra console để biết thêm chi tiết.');
            });
    });
</script>

@endsection
