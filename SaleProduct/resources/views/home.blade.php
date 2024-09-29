@extends('layouts.app')

@section('content')
<div class="relative bg-white overflow-hidden">
    <!-- Search and Filter Section -->
    <section class="py-6 bg-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center justify-between space-y-2 md:space-y-0">
                <!-- Search bar -->
                <form method="GET" action="{{ route('home') }}" class="w-full md:w-4/12 mb-4 flex items-center">
                    <div class="relative w-full">
                        <input 
                            type="text" 
                            name="keyword" 
                            placeholder="Tìm kiếm sản phẩm..." 
                            value="{{ request()->keyword }}" 
                            class="w-full border border-gray-300 rounded-l-lg shadow-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-300 ease-in-out transform hover:shadow-lg" 
                        />
                        <div class="absolute right-0 top-0 mt-2 mr-2 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 2a9 9 0 100 18 9 9 0 000-18zM21 21l-4.35-4.35"/></svg>
                        </div>
                    </div>
                    <button type="submit" class="px-5 py-3 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none text-sm">
                        Tìm
                    </button>
                </form>
                
                <!-- Product type filter -->
                <div class="w-full md:w-3/12 mb-4">
                    <form method="GET" action="{{ route('home') }}" class="flex">
                        <input type="hidden" name="keyword" value="{{ request()->keyword }}">
                        <select name="product_type" class="w-full border border-gray-300 p-2 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-300 ease-in-out">
                            <option value="">Chọn loại sản phẩm</option>
                            @foreach($loaiSanPhams as $loaiSanPham)
                                <option value="{{ $loaiSanPham->LoaiSanPhamID }}" 
                                    {{ $selectedProductType == $loaiSanPham->LoaiSanPhamID ? 'selected' : '' }}>
                                    {{ $loaiSanPham->TenLoaiSanPham }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out transform hover:scale-105">Lọc</button>
                    </form>
                </div>

                <!-- Price sorting filter -->
                <div class="w-full md:w-3/12 mb-4">
                    <form method="GET" action="{{ route('home') }}" class="flex">
                        <input type="hidden" name="keyword" value="{{ request()->keyword }}">
                        <input type="hidden" name="product_type" value="{{ $selectedProductType }}">
                        <select name="sort_by_price" class="w-full border border-gray-300 p-2 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-300 ease-in-out">
                            <option value="">Sắp xếp theo giá</option>
                            <option value="asc" {{ $selectedSortByPrice == 'asc' ? 'selected' : '' }}>Giá tăng dần</option>
                            <option value="desc" {{ $selectedSortByPrice == 'desc' ? 'selected' : '' }}>Giá giảm dần</option>
                        </select>
                        <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out transform hover:scale-105">Lọc</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Featured Products Section -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-center mb-8 bg-gray-300 p-4 rounded relative">Danh Sách Sản Phẩm</h2> 
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @if($sanphams->count() > 0)
                    @foreach($sanphams as $sanpham)
                        <div class="relative bg-white p-3 rounded-lg shadow-lg overflow-hidden transition-transform transform hover:scale-105">
                            <img src="{{ asset('storage/' . $sanpham->HinhAnh) }}" alt="{{ $sanpham->TenSanPham }}" class="w-full h-48 object-cover rounded-t-lg">
                            <div class="p-2">
                                <h3 class="text-lg font-bold">{{ $sanpham->TenSanPham }}</h3>
                                <div class="flex items-center justify-between mt-1">
                                    <p class="text-gray-600">Giá: <span class="text-red-600 font-semibold">{{ number_format($sanpham->Gia, 0, ',', '.') }} VND</span></p>
                                    
                                    <!-- Form để thêm sản phẩm vào giỏ hàng -->
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="SanPhamID" value="{{ $sanpham->SanPhamID }}">
                                        <input type="hidden" name="SoLuong" value="1">
                                        <button type="submit" class="flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transition duration-300">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center col-span-4">Không tìm thấy sản phẩm nào.</p>
                @endif
            </div>
            <!-- Phân trang -->
            <div class="mt-10 flex justify-center">
                <nav aria-label="Page navigation">
                    <ul class="inline-flex -space-x-px">
                        <li>
                            <a href="{{ $sanphams->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l hover:bg-blue-500 hover:text-white transition duration-300 {{ $sanphams->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $sanphams->onFirstPage() ? 'disabled' : '' }}>
                                Trước
                            </a>
                        </li>
                        @for ($i = 1; $i <= $sanphams->lastPage(); $i++)
                            <li>
                                <a href="{{ $sanphams->url($i) }}" class="px-4 py-2 text-sm font-medium {{ $i == $sanphams->currentPage() ? 'text-white bg-blue-600' : 'text-gray-700 bg-white' }} border border-gray-300 hover:bg-blue-500 hover:text-white transition duration-300">
                                    {{ $i }}
                                </a>
                            </li>
                        @endfor
                        <li>
                            <a href="{{ $sanphams->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r hover:bg-blue-500 hover:text-white transition duration-300 {{ $sanphams->hasMorePages() ? '' : 'opacity-50 cursor-not-allowed' }}" {{ $sanphams->hasMorePages() ? '' : 'disabled' }}>
                                Sau
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

</div>
<script src="{{ asset('js/custom.js') }}"></script>
@endsection
