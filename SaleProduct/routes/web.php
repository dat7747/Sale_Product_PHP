<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;

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

// Route cho trang đăng ký
Route::get('/register', [LoginController::class, 'register'])->name('register');

// Route xử lý đăng ký
Route::post('/register', [LoginController::class, 'store'])->name('register.store');

// Route bảo vệ, chỉ cho phép người dùng đã đăng nhập
Route::middleware(['auth'])->group(function () {
   
});