<?php

namespace App\Http\Controllers;
use App\Models\LoaiSanPham;
use App\Models\SanPham;
use App\Models\SanPhamGiamGia;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh sách sản phẩm có giảm giá
        $sanphamGiamGias = SanPham::with(['sanPhamGiamGia' => function($query) {
            $query->where('NgayBatDauGiamGia', '<=', now())
                  ->where('NgayKetThucGiamGia', '>=', now());
        }])
        ->whereHas('sanPhamGiamGia', function($query) {
            $query->where('NgayBatDauGiamGia', '<=', now())
                  ->where('NgayKetThucGiamGia', '>=', now());
        })
        ->paginate(12);
    
        // Lấy danh sách sản phẩm đầy đủ
        $sanphams = SanPham::query();
    
        // Lọc theo loại sản phẩm
        if ($request->has('product_type') && $request->product_type != '') {
            $sanphams->where('LoaiSanPhamID', $request->product_type);
        }
    
        // Tìm kiếm theo tên sản phẩm
        if ($request->has('keyword') && $request->keyword != '') {
            $sanphams->where('TenSanPham', 'like', '%' . $request->keyword . '%');
        }
    
        // Sắp xếp theo giá
        if ($request->has('sort_by_price') && $request->sort_by_price != '') {
            if ($request->sort_by_price == 'asc') {
                $sanphams->orderBy('Gia', 'asc');
            } elseif ($request->sort_by_price == 'desc') {
                $sanphams->orderBy('Gia', 'desc');
            }
        }
    
        // Phân trang
        $sanphams = $sanphams->paginate(12);
    
        $loaiSanPhams = LoaiSanPham::all();
    
        // Trả về view
        return view('home', [
            'sanphams' => $sanphams,
            'sanphamGiamGias' => $sanphamGiamGias,
            'loaiSanPhams' => $loaiSanPhams,
            'selectedProductType' => $request->product_type,
            'selectedSortByPrice' => $request->sort_by_price,
            'keyword' => $request->keyword
        ]);
    }
    
    
    public function search(Request $request)
    {
        $keyword = $request->input('keyword'); 

        $sanphams = SanPham::where('TenSanPham', 'LIKE', "%$keyword%")->get();

        return view('home', compact('sanphams'));
    }


}
