<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function  index(){
        return view('login.login');
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
            // Nếu có lỗi, in ra để kiểm tra
            dd($validator->errors());
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Tạo khách hàng mới với mật khẩu đã mã hóa
        KhachHang::create([
            'HoTen' => $request->name,
            'Email' => $request->email,
            'SoDienThoai' => $request->phone,
            'DiaChi' => $request->address,
            'MatKhau' => Hash::make($request->password), // Mã hóa mật khẩu
        ]);
    
        return redirect()->route('home')->with('success', 'Đăng ký thành công!'); // Đảm bảo route 'home' tồn tại
    }
    
    
}
