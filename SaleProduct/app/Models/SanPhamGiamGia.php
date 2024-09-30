<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SanPhamGiamGia extends Model
{
    protected $table = 'SanPhamGiamGia'; // Tên bảng
    protected $primaryKey = 'ID'; // Khóa chính của bảng
    protected $fillable = ['SanPhamID', 'GiaGiam', 'NgayBatDauGiamGia', 'NgayKetThucGiamGia'];

    public $timestamps = false;

    // Thiết lập quan hệ với bảng SanPham
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'SanPhamID');
    }

    // Kiểm tra nếu ngày giảm giá hợp lệ
    public function isDiscountValid()
    {
        $now = Carbon::now();
        return $this->NgayKetThucGiamGia >= $now && $this->NgayBatDauGiamGia <= $this->NgayKetThucGiamGia;
    }

    // Kiểm tra nếu giảm giá còn hiệu lực
    public function isDiscountActive()
    {
        $now = Carbon::now();
        return $this->NgayBatDauGiamGia <= $now && $this->NgayKetThucGiamGia >= $now;
    }
}
