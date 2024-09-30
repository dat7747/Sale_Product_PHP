<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\LoaiSanPham;
use App\Models\SanPhamGiamGia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class SanPhamController extends Controller
{
    //lấy danh sách sản phẩm và loại sản phẩm
    public function index(){
        $sanphams = SanPham::with('loaiSanPham')->get();
        $discountedProducts = SanPhamGiamGia::with('sanPham')->get();
        return view('sanpham.index', compact('sanphams','discountedProducts'));
    }

    //fomr thêm sản phẩm
    public function create(){
        $loaiSanPhams = LoaiSanPham::all();

        return view('sanpham.create',compact('loaiSanPhams'));
    }


    //save product
    public function store(Request $request){  
        $request->validate([
            'TenSanPham' => 'required',
            'LoaiSanPhamID' => 'required',
            'Gia' => 'required|numeric',
            'Mota' => 'nullable',
            'ThuongHieu' => 'required',
            'HinhAnh' => 'nullable|image',
            'NgaySanXuat' => 'required|date',
            'BaoHanh' => 'required|numeric',
        ]);
    
        // Upload and store image
        $path = null;
        if ($request->hasFile('HinhAnh')) {
            $path = $request->file('HinhAnh')->store('images', 'public');
        }
        Log::info('Image Path: ' . $path);
        // Create new product
        SanPham::create([
            'TenSanPham' => $request->TenSanPham ?? '',
            'LoaiSanPhamID' => $request->LoaiSanPhamID,
            'Gia' => $request->Gia ?? '',
            'Mota' => $request->Mota ?? '',
            'ThuongHieu' => $request->ThuongHieu?? '',
            'HinhAnh' => $path ?? '',
            'NgaySanXuat' => $request->NgaySanXuat ?? '',
            'BaoHanh' => $request->BaoHanh ?? '',
        ]);
    
        return redirect()->route('sanpham.index')->with('success', 'Thêm sản phẩm thành công!');
    }
    
    //edit product 
    public function edit(SanPham $sanpham){
        $loaiSanPhams = LoaiSanPham::all();

        return view('sanpham.edit',compact('sanpham','loaiSanPhams'));
    }

    //update product
    public function update(Request $request, SanPham $sanpham){
        $request->validate([
            'TenSanPham' => 'required' ?? '',
            'LoaiSanPhamID' => 'required' ?? '',
            'Gia' => 'required|numeric' ?? '',
            'Mota' => 'nullable' ?? '',
            'ThuongHieu' => 'required' ?? '',
            'HinhAnh' => 'nullable|image' ?? '',
            'NgaySanXuat' => 'required|date' ?? '' ,
            'BaoHanh' => 'required|numeric' ?? '',
        ]);

        if ($request->hasFile('HinhAnh')) {
            $path = $request->file('HinhAnh')->store('images', 'public');
            $sanpham->HinhAnh = $path;
        }

        $sanpham->update($request->all());

        return redirect()->route('sanpham.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    //delete product
    public function destroy(SanPham $sanpham){
        $sanpham ->delete();
        return redirect()->route('sanpham.index')->with('success', 'Xóa sản phẩm thành công!');
    }
    
    public function search(Request $request)
    {
        $search = $request->input('query');
    
        // Tìm sản phẩm theo tên sản phẩm
        $sanphams = SanPham::with('loaiSanPham') // Tải thông tin loại sản phẩm
            ->where('TenSanPham', 'LIKE', '%' . $search . '%')
            ->get();
    
        return response()->json($sanphams);
    }
    
    //save product discount
    public function luuGiamGia(Request $request, $id)
    {
        // Lấy ngày hiện tại
        $now = Carbon::now()->toDateString();
    
        // Xác thực dữ liệu
        $validatedData = $request->validate([
            'discountPercentage' => 'required|numeric|min:0|max:100',
            'discountStart' => 'required|date|before_or_equal:discountExpiry',
            'discountExpiry' => 'required|date|after_or_equal:'.$now,
        ]);
    
        // Lấy sản phẩm
        $sanPham = SanPham::findOrFail($id);
    
        //kiểm tra sản phẩm đã tồn tại hay chưa
        $sanPhamGiamGia = SanPhamGiamGia::where('SanPhamID',$sanPham->SanPhamID)->first();

        //nếu có
        if($sanPhamGiamGia){
            $sanPhamGiamGia->update([
                'GiaGiam'=> $validatedData['discountPercentage'],
                'NgayBatDauGiamGia' => $validatedData['discountStart'],
                'NgayKetThucGiamGia' => $validatedData['discountExpiry'],
            ]);
            return redirect()->back()->with('success', 'Giảm giá đã được cập nhật thành công!');
        }else
        {
            // Tạo bản ghi giảm giá mới
            SanPhamGiamGia::create([
                'SanPhamID' => $sanPham->SanPhamID, // Chắc chắn rằng thuộc tính này là đúng
                'GiaGiam' => $validatedData['discountPercentage'],
                'NgayBatDauGiamGia' => $validatedData['discountStart'],
                'NgayKetThucGiamGia' => $validatedData['discountExpiry'],
            ]);

            return redirect()->back()->with('success', 'Giảm giá đã được áp dụng thành công!');
        }
    }
    
    //delete product discount
    public function removeDiscount($id)
    {
        // Tìm sản phẩm giảm giá theo ID của bảng SanPhamGiamGia
        $sanphamGiamGia = SanPhamGiamGia::find($id);
        if ($sanphamGiamGia) {
            $sanphamGiamGia->delete(); // Xóa sản phẩm khỏi bảng SanPhamGiamGia
            return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi danh sách giảm giá.');
        }
        return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
    }
    
}
