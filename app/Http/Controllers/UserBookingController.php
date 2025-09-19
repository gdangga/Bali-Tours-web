<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class UserBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('package')
            ->where('user_id', auth()->id())
            ->orderBy('tour_date', 'desc')
            ->paginate(10); // Menggunakan paginate untuk halaman

        return view('bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        // Pastikan user hanya bisa melihat booking miliknya
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load('package', 'user'); // Eager load relasi

        return view('bookings.show', compact('booking'));
    }
}