@extends('layouts.app')

@section('content')
<div class="relative bg-white overflow-hidden">
    <!-- Hero section -->
    <div class="relative pt-16 pb-32 flex content-center items-center justify-center min-h-screen">
        <div class="absolute top-0 w-full h-full bg-center bg-cover" style="background-image: url('https://via.placeholder.com/1920x1080')">
            <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
        </div>
        <div class="container relative mx-auto">
            <div class="items-center flex flex-wrap">
                <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
                    <div class="pr-12">
                        <h1 class="text-white font-semibold text-5xl">
                            Chào Mừng Bạn Đến Cửa Hàng Điện Tử
                        </h1>
                        <p class="mt-4 text-lg text-gray-300">
                            Chúng tôi cung cấp những sản phẩm điện tử hàng đầu với giá cạnh tranh.
                        </p>
                        <a href="#" class="mt-8 px-8 py-3 bg-yellow-500 text-white font-bold uppercase rounded-lg shadow-lg hover:bg-yellow-600 transition">Khám Phá Ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products Section -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-center mb-8">Sản Phẩm Nổi Bật</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Product 1 -->
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <img src="https://via.placeholder.com/400x300" alt="Product" class="w-full h-64 object-cover rounded-t-lg">
                    <div class="p-4">
                        <h3 class="text-xl font-bold">Điện Thoại iPhone 13</h3>
                        <p class="text-gray-600 mt-2">Giá: 30,000,000 VND</p>
                    </div>
                </div>
                <!-- Product 2 -->
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <img src="https://via.placeholder.com/400x300" alt="Product" class="w-full h-64 object-cover rounded-t-lg">
                    <div class="p-4">
                        <h3 class="text-xl font-bold">Máy Giặt Samsung</h3>
                        <p class="text-gray-600 mt-2">Giá: 6,500,000 VND</p>
                    </div>
                </div>
                <!-- Product 3 -->
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <img src="https://via.placeholder.com/400x300" alt="Product" class="w-full h-64 object-cover rounded-t-lg">
                    <div class="p-4">
                        <h3 class="text-xl font-bold">Tủ Lạnh LG 2 Cửa</h3>
                        <p class="text-gray-600 mt-2">Giá: 12,000,000 VND</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
