<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiSanPham extends Model
{
    use HasFactory;
    protected $table = 'LoaiSanPham'; 
    protected $primaryKey = 'LoaiSanPhamID'; 
    protected $fillable = ['TenLoaiSanPham'];

    public $timestamps = false;
}

