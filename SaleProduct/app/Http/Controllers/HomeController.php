<?php

namespace App\Http\Controllers;
use App\Models\LoaiSanPham;
use App\Models\SanPham;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $sanphams = SanPham::query();
        $loaiSanPhams = LoaiSanPham::all();
    
        // Lọc theo loại sản phẩm nếu có
        if ($request->has('product_type') && $request->product_type != '') {
            $sanphams->where('LoaiSanPhamID', $request->product_type);
        }
    
        // Tìm kiếm theo tên sản phẩm nếu có
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
    
        // Phân trang danh sách sản phẩm
        $sanphams = $sanphams->paginate(12); 
    
        // Trả về view cùng với các thông số lọc và phân trang
        return view('home', [
            'sanphams' => $sanphams,
            'loaiSanPhams' => $loaiSanPhams,
            'selectedProductType' => $request->product_type,
            'selectedSortByPrice' => $request->sort_by_price,
            'keyword' => $request->keyword // Trả về từ khóa tìm kiếm
        ]);
    }
    
    public function search(Request $request)
    {
        $keyword = $request->input('keyword'); 

        $sanphams = SanPham::where('TenSanPham', 'LIKE', "%$keyword%")->get();

        return view('home', compact('sanphams'));
    }


}
