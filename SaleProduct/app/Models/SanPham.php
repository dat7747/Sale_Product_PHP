<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table ="SanPham";
    protected $primaryKey = 'SanPhamID';
    protected $fillable =  ['TenSanPham', 'LoaiSanPhamID', 'Gia', 'Mota', 'ThuongHieu', 'HinhAnh', 'NgaySanXuat', 'BaoHanh'];

    //relationship with table loaisanpham
    public function loaiSanPham()
    {
        return $this->belongsTo(LoaiSanPham::class, 'LoaiSanPhamID');
    }

    //relationship with table sanphamgiamgia
    public function sanPhamGiamGia(){
        return $this->hasOne(SanPhamGiamGia::class, 'SanPhamID');
    }
    public $timestamps = false;
}