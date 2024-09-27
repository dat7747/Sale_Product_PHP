<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function  index(){
        return view('login.login');
    }
    
    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Trim email và password
        $credentials['email'] = trim($credentials['email']);
        $passwordInput = trim($credentials['password']);

        // Tìm khách hàng trong bảng 'khachhang'
        $khachHang = KhachHang::where('Email', $credentials['email'])->first(); // Đảm bảo trường Email viết hoa đúng

        // Kiểm tra và log kết quả
        if ($khachHang) {
        
            // So sánh mật khẩu nhập vào với mật khẩu được mã hóa trong cơ sở dữ liệu
            if (Hash::check($passwordInput, $khachHang->MatKhau)) { // Sử dụng MatKhau
                Auth::login($khachHang);
                $request->session()->regenerate();
                return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
            } else {
                Log::warning('Mật khẩu không khớp cho email: ' . $credentials['email']);
            }
        } else {
            Log::warning('Không tìm thấy khách hàng với email: ' . $credentials['email']);
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác',
        ])->withInput();
    }

    
    public function register(){
        return view ('login.register');
    }
    public function store(Request $request)
    {
        // Thực hiện kiểm tra dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:100|unique:khachhang', 
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'password' => 'required|string|min:6|confirmed', 
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Tạo khách hàng mới với mật khẩu đã mã hóa
        $khachHang = KhachHang::create([
            'HoTen' => $request->name,
            'Email' => $request->email,
            'SoDienThoai' => $request->phone,
            'DiaChi' => $request->address,
            'MatKhau' => Hash::make($request->password),
            'role' => 0,
        ]);
    
        // Đăng nhập ngay sau khi đăng ký thành công
        Auth::login($khachHang); // Đăng nhập người dùng
    
        // Kiểm tra xem đăng nhập có thành công không
        if (Auth::check()) {
            \Log::info('Current session:', [session()->all()]);
            \Log::info('User is logged in:', [Auth::user()]); // Log thông tin người dùng
            \Log::info('Redirecting to home after successful registration.');
            return redirect()->route('home')->with('success', 'Đăng ký thành công!'); // Chuyển hướng đến trang chủ
        } else {
            \Log::warning('User login failed');
            return redirect()->back()->with('error', 'Đăng nhập thất bại.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
    
        // Invalidate the session.
        $request->session()->invalidate();
    
        // Regenerate the session token to prevent session fixation attacks.
        $request->session()->regenerateToken();
    
        // Chuyển hướng người dùng về trang đăng nhập hoặc trang chủ.
        return redirect('/login');
    }
}
