<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KhachHangController extends Controller
{
    public function  index(){
        return view('khachhang.info');
    }
}
