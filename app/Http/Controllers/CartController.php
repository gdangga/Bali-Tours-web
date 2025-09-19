<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with(['package', 'package_option'])
            ->where('user_id', auth()->id())
            ->get();
            
        $total = $cartItems->sum('total_price');

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function destroy(Cart $cart)
    {
        // Pastikan user hanya bisa menghapus cart miliknya sendiri
        if ($cart->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}