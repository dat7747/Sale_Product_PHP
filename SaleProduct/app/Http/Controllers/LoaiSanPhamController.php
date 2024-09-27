<?php

namespace App\Http\Controllers;

use App\Models\LoaiSanPham;
use Illuminate\Http\Request;

class LoaiSanPhamController extends Controller
{
    public function index()
    {
        $loaisanphams = LoaiSanPham::all();
        return view('loaisanpham.index', compact('loaisanphams'));
    }
    

    public function create(){
        return view('loaisanpham.create');
    }


    public function store(Request $request){
        $request ->validate([
            "TenLoaiSanPham" => 'required',
        ]);

        LoaiSanPham::create($request->all());

        return redirect()->route('loaisanpham.index')->with('success','Thêm Loại sản phẩm thành công');
    }

    public function edit($id) {
        $loaiSanPham = LoaiSanPham::find($id); 
        if (!$loaiSanPham) {
            return redirect()->back()->with('error', 'Không tìm thấy loại sản phẩm');
        }
        return view('loaisanpham.edit', compact('loaiSanPham'));
    }
    
    

    public function update(Request $request, $id) {
        $request->validate([
            'TenLoaiSanPham' => 'required',
        ]);
    
        $loaiSanPham = LoaiSanPham::find($id); // Tìm kiếm loại sản phẩm theo ID
        if (!$loaiSanPham) {
            return redirect()->back()->with('error', 'Không tìm thấy loại sản phẩm');
        }
    
        $loaiSanPham->TenLoaiSanPham = $request->input('TenLoaiSanPham');
        $loaiSanPham->save();
    
        return redirect()->route('loaisanpham.index')->with('success', 'Sửa thành công');
    }
    

    public function destroy($id){
        $loaiSanPham = LoaiSanPham::find($id);
        if(!$loaiSanPham){
            return redirect()->route('loaisanpham.index')->with('errol','Not Found');
        }

        $loaiSanPham->delete();
        return redirect()->route('loaisanpham.index')->with('success','Success Delete');
    }
}
