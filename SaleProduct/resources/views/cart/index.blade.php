@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-4xl font-semibold mb-8 text-center text-gray-800">Giỏ Hàng</h1>

        @if (session('success'))
            <div class="mb-5 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($gioHangs->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="px-6 py-4 text-left">Sản Phẩm</th>
                            <th class="px-6 py-4 text-center">Hình Ảnh</th>
                            <th class="px-6 py-4 text-center">Số Lượng</th>
                            <th class="px-6 py-4 text-center">Giá</th>
                            <th class="px-6 py-4 text-center">Tổng</th>
                            <th class="px-6 py-4 text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                        @foreach($gioHangs as $gioHang)
                            <tr class="hover:bg-gray-100 transition duration-300">
                                <td class="px-6 py-4 text-left">
                                    <h3 class="text-lg font-semibold">{{ $gioHang->product->TenSanPham }}</h3>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <img src="{{ asset('storage/' . $gioHang->product->HinhAnh) }}" alt="{{ $gioHang->product->TenSanPham }}" class="w-24 h-24 object-cover rounded-lg shadow-md">
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('cart.update', $gioHang->GioHangID) }}" method="POST" class="inline-flex items-center">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" name="action" value="decrease" class="bg-gray-300 text-black px-2 py-1 rounded-lg hover:bg-gray-400 transition duration-300">-</button>
                                        <span class="mx-2 text-lg">{{ $gioHang->SoLuong }}</span>
                                        <button type="submit" name="action" value="increase" class="bg-gray-300 text-black px-2 py-1 rounded-lg hover:bg-gray-400 transition duration-300">+</button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($gioHang->product->sanPhamGiamGia && $gioHang->product->sanPhamGiamGia->isDiscountActive())
                                        @php
                                            // Tính giá giảm theo phần trăm
                                            $giaGoc = $gioHang->product->Gia; // Giá gốc
                                            $phanTramGiam = $gioHang->product->sanPhamGiamGia->GiaGiam; // Giá giảm (20% ở đây)
                                            $giaGiam = $giaGoc * (1 - ($phanTramGiam / 100)); // Tính giá giảm
                                        @endphp
                                        <span class="text-lg font-semibold text-red-500">{{ number_format($giaGiam, 0, ',', '.') }} VND</span>
                                        <div class="text-gray-500 line-through">{{ number_format($gioHang->product->Gia, 0, ',', '.') }} VND</div>
                                    @else
                                        <span class="text-lg font-semibold">{{ number_format($gioHang->product->Gia, 0, ',', '.') }} VND</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        // Tính giá dựa trên giá gốc hoặc giá giảm
                                        $gia = $gioHang->product->sanPhamGiamGia && $gioHang->product->sanPhamGiamGia->isDiscountActive() 
                                            ? $giaGiam 
                                            : $gioHang->product->Gia; // Nếu có giảm giá thì lấy giá giảm
                                        $tong = $gia * $gioHang->SoLuong;
                                    @endphp
                                    <span class="text-lg font-semibold">{{ number_format($tong, 0, ',', '.') }} VND</span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('cart.destroy', $gioHang->GioHangID) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 transition duration-300">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tổng giá trị giỏ hàng -->
            <div class="flex justify-end mt-6">
                <div class="text-right">
                    <h3 class="text-xl font-bold">Tổng thanh toán: 
                        <span class="text-2xl text-red-500">
                            {{ number_format($gioHangs->sum(fn($gioHang) => ($gioHang->product->sanPhamGiamGia && $gioHang->product->sanPhamGiamGia->isDiscountActive() ? 
                                $giaGiam = $gioHang->product->Gia * (1 - ($gioHang->product->sanPhamGiamGia->GiaGiam / 100)) : 
                                $gioHang->product->Gia) * $gioHang->SoLuong), 0, ',', '.') }} VND
                        </span>
                    </h3>
                    <a href="#" class="mt-4 inline-block bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">Thanh Toán</a>
                </div>
            </div>
        @else
            <p class="text-center text-lg text-gray-600">Giỏ hàng của bạn trống.</p>
        @endif
    </div>
@endsection
