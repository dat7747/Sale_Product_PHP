<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = "giohang";
    protected $primaryKey = 'GioHangID';
    protected $fillable = [
        'KhachHangID',
        'SanPhamID',
        'SoLuong',
    ];

    public function customer(){
        return $this->belongsTo(KhachHang::class,'KhachHangID');
    }

    public function product(){
        return $this->belongsTo(SanPham::class,'SanPhamID' );
    }    
    public $timestamps = false;
}
