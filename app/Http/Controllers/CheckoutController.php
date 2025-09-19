<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    /**
     * Memproses item keranjang yang dipilih menjadi booking.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'cart_item_ids' => 'required|array|min:1',
            'cart_item_ids.*' => [
                'integer',
                // Pastikan setiap ID ada di tabel carts & milik user yang sedang login
                Rule::exists('carts', 'id')->where('user_id', Auth::id()),
            ],
        ]);

        // 2. Ambil item keranjang yang valid dari database
        $cartItemsToCheckout = Cart::whereIn('id', $validated['cart_item_ids'])->get();

        // 3. Loop setiap item & buat booking baru
        foreach ($cartItemsToCheckout as $item) {
            Booking::create([
                'user_id' => $item->user_id,
                'package_id' => $item->package_id,
                'tour_date' => $item->tour_date,
                'pickup_time' => $item->pickup_time,
                'pickup_location' => $item->pickup_location,
                'num_people' => $item->num_people,
                'participants' => $item->participants,
                'total_price' => $item->total_price,
                'notes' => $item->notes,
                'payment_method' => 'cash', // Default ke cash, bisa dikembangkan nanti
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            // 4. Hapus item dari keranjang setelah booking dibuat
            $item->delete();
        }

        // 5. Redirect ke halaman daftar booking dengan pesan sukses
        return redirect()->route('bookings.index')
               ->with('success', count($cartItemsToCheckout) . ' item(s) have been successfully booked!');
    }
}