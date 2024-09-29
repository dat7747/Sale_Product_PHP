<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Cart;

class CartItemCount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $gioHangs = Cart::with('product')->where('KhachHangID', auth()->id())->get();
            $totalItems = $gioHangs->sum('SoLuong');
        } else {
            $totalItems = 0; // Khi chưa đăng nhập
        }
    
        View::share('totalItems', $totalItems);
        
        return $next($request);
    }
}
