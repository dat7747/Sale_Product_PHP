<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\LoaiSanPham;
use Illuminate\Http\Request;

class SanPhamController extends Controller
{
    //lấy danh sách sản phẩm và loại sản phẩm
    public function index(){
        $sanphams = SanPham::with('loaiSanPham')->get();
        return view('sanpham.index', compact('sanphams'));
    }

    //fomr thêm sản phẩm
    public function create(){
        $loaiSanPhams = LoaiSanPham::all();

        return view('sanpham.create',compact('loaiSanPhams'));
    }


    //save product
    public function store(Request $request){
        $request ->validate([
            'TenSanPham' => 'required',
            'LoaiSanPhamID' => 'required',
            'Gia' => 'required|numeric',
            'Mota' => 'nullable',
            'ThuongHieu' => 'required',
            'HinhAnh' => 'nullable|image',
            'NgaySanXuat' => 'required|date',
            'BaoHanh' => 'required|numeric',
        ]);

        if($request ->hasFile('HinhAnh')){
            $path = $request->file('HinhAnh')->store('images','public');
        }

        SanPham::create([
            'TenSanPham' => $request->TenSanPham,
            'LoaiSanPhamID' => $request->LoaiSanPhamID,
            'Gia' => $request->Gia,
            'Mota' => $request->Mota,
            'ThuongHieu' => $request->ThuongHieu,
            'HinhAnh' => $path ?? null,
            'NgaySanXuat' => $request->NgaySanXuat,
            'BaoHanh' => $request->BaoHanh,
        ]);
        return redirect()->route('sanpham.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit(SanPham $sanpham){
        $loaiSanPhams = LoaiSanPham::all();

        return view('sanpham.edit',compact('sanpham','loaiSanPhams'));
    }


    public function update(Request $request, SanPham $sanpham){
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

        if ($request->hasFile('HinhAnh')) {
            $path = $request->file('HinhAnh')->store('images', 'public');
            $sanpham->HinhAnh = $path;
        }

        $sanpham->update($request->all());

        return redirect()->route('sanpham.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }


    public function delete(SanPham $sanpham){
        $sanpham ->delete();
        return redirect()->route('sanpham.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}
