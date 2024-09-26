<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    //khai báo tên table
    protected $table = 'khachhang';

    //khai báo khóa chính
    protected $primarykey = 'KhachHangID';

    //các thuộc tính được điền vào form
    protected $fillable = [
        'HoTen','Email','SoDienThoai','DiaChi','MatKhau',
    ];
    use HasFactory;
}
