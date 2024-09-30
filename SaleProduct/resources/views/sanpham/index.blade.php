@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-4xl font-bold mb-4 text-center text-gray-800 animate-bounce">Quản lý sản phẩm</h1>

    <!-- Thanh tìm kiếm -->
    <div class="flex justify-end mb-4">
        <input type="text" id="search" placeholder="Tìm kiếm sản phẩm..." class="w-1/3 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
    </div>

    <!-- Nút thêm sản phẩm và danh sách sản phẩm giảm giá -->
    <div class="flex justify-end mb-4 space-x-4">
        <a href="{{ route('sanpham.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded inline-block hover:bg-blue-600 transition-all duration-300">Thêm sản phẩm</a>
        <button id="discountListBtn" class="bg-yellow-500 text-white px-4 py-2 rounded inline-block hover:bg-yellow-600 transition-all duration-300" onclick="showDiscountListModal()">Danh sách sản phẩm giảm giá</button>
    </div>

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
                        <!-- Nút Giảm Giá -->
                        <button 
                            onclick="showDiscountModal('{{ $sanpham->SanPhamID }}')" 
                            class="text-yellow-600 hover:text-yellow-800 transition">
                            Giảm Giá
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Giảm Giá -->
    <div id="discountModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-bold mb-4">Giảm giá cho sản phẩm</h2>
            <form id="discountForm" action="" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="discountPercentage" class="block text-gray-700">Phần trăm giảm giá:</label>
                    <input type="number" id="discountPercentage" name="discountPercentage" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" min="0" max="100" required>
                </div>
                <div class="mb-4">
                    <label for="discountStart" class="block text-gray-700">Ngày bắt đầu:</label>
                    <input type="date" id="discountStart" name="discountStart" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" required>
                </div>
                <div class="mb-4">
                    <label for="discountExpiry" class="block text-gray-700">Ngày kết thúc:</label>
                    <input type="date" id="discountExpiry" name="discountExpiry" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" required>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-all" onclick="closeDiscountModal()">Hủy</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-all">Lưu</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Danh sách sản phẩm giảm giá -->
    <div id="discountListModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl">
            <h2 class="text-2xl font-bold mb-4 text-center">Danh sách sản phẩm giảm giá</h2>
            <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-200 text-left text-sm uppercase font-semibold text-gray-600">
                        <th class="px-4 py-3">Tên sản phẩm</th>
                        <th class="px-4 py-3 text-center">Giá giảm (%)</th>
                        <th class="px-4 py-3 text-center">Ngày bắt đầu</th>
                        <th class="px-4 py-3 text-center">Ngày kết thúc</th>
                        <th class="px-4 py-3 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody id="discountedProductsTable" class="text-sm">
                    @foreach($discountedProducts as $product)
                        <tr class="border-b hover:bg-gray-100 transition duration-200">
                            <td class="px-4 py-2">{{ $product->sanPham->TenSanPham }}</td>
                            <td class="px-4 py-2 text-center">{{ number_format($product->GiaGiam, 0, ',', '.') }}%</td>
                            <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($product->NgayBatDauGiamGia)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($product->NgayKetThucGiamGia)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-center">
                            <form action="{{ route('sanpham.removeDiscount', $product->ID) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giảm giá?');" style="display:inline;">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 transition">Xóa</button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-end mt-4">
                <button class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-all" onclick="closeDiscountListModal()">Đóng</button>
            </div>
        </div>
    </div>
</div>

</div>

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
<script src="{{ asset('js/sanpham/sanpham.js') }}"></script>
@endsection
