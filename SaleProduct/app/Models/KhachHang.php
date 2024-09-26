<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class KhachHang extends Authenticatable 
{
    use HasFactory, Notifiable;

    protected $table = 'khachhang';
    protected $primaryKey = 'KhachHangID';

    protected $fillable = [
        'HoTen','Email','SoDienThoai','DiaChi','MatKhau',
    ];


    protected $hidden = [
        'MatKhau', 
    ];
}

