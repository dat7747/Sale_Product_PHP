<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\LoaiSanPhamController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route cho trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route cho trang đăng nhập
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'processLogin'])->name('login.process');

// Route cho trang đăng ký
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'store'])->name('register.store');

// Route cho đăng xuất
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Route bảo vệ, chỉ cho phép người dùng đã đăng nhập
Route::middleware(['auth'])->group(function () {
    // Route xử lý info
    Route::get('/info', [KhachHangController::class, 'index'])->name('info');

    //Route quản lý sản phẩm 
    Route::resource('sanpham', SanPhamController::class);

    //Route quản lý loai sản phẩm 
    Route::resource('loaisanpham', LoaiSanPhamController::class);
});