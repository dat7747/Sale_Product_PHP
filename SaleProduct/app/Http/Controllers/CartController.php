<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\SanPham;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\View;

class CartController extends Controller
{
    // view list product 
    public function index()
    {
        if (auth()->check()) {
            // Lấy giỏ hàng và thông tin sản phẩm liên quan
            $gioHangs = Cart::with(['product', 'product.sanPhamGiamGia']) // Lấy cả sản phẩm và thông tin giảm giá
                ->where('KhachHangID', auth()->id())
                ->get();
        } else {
            $gioHangs = collect(); // Nếu chưa đăng nhập, khởi tạo một collection rỗng
        }
    
        // Log thông tin sản phẩm
        foreach ($gioHangs as $gioHang) {
            $product = $gioHang->product;
            $discount = $product->sanPhamGiamGia;
    
            if ($discount && $discount->isDiscountActive()) {
                Log::info('Sản phẩm giảm giá', [
                    'Tên sản phẩm' => $product->TenSanPham,
                    'Giá gốc' => $product->Gia,
                    'Giá giảm' => $discount->GiaGiam,
                ]);
            } else {
                Log::info('Sản phẩm không giảm giá', [
                    'Tên sản phẩm' => $product->TenSanPham,
                    'Giá' => $product->Gia,
                ]);
            }
        }
    
        $totalItems = $gioHangs->sum('SoLuong');
        return view('cart.index', compact('gioHangs', 'totalItems'));
    }
    
    // add product in to cart
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'SanPhamID' => 'required|exists:SanPham,SanPhamID',
            'SoLuong' => 'required|integer|min:1',
        ]);

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $existingCart = Cart::where('KhachHangID', auth()->id())
                            ->where('SanPhamID', $request->SanPhamID)
                            ->first();

        if ($existingCart) {
            // Nếu đã có, tăng số lượng
            $existingCart->SoLuong += $request->SoLuong;
            $existingCart->save();
        } else {
            // Nếu chưa có, thêm mới vào giỏ hàng
            Cart::create([
                'KhachHangID' => auth()->id(),
                'SanPhamID' => $request->SanPhamID,
                'SoLuong' => $request->SoLuong,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function destroy($id)
    {
        $gioHang= Cart::where('GioHangID',$id)->first();
        
        if ($gioHang) {
            $gioHang->delete();
            return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa.');
        } else {
            return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại.');
        }
    }

    //Update quantity product
    public function update(Request $request,$id){
        $gioHang = Cart::findOrFail($id);
        if($request->action === 'increase'){
            $gioHang->SoLuong += 1;
        }
        elseif($request->action === 'decrease' && $gioHang -> SoLuong > 1){
            $gioHang->SoLuong -= 1;
        }

        $gioHang -> save();

        return redirect()->route('cart.index')->with('success', 'Cập nhật số lượng thành công.'); 
    }
}
