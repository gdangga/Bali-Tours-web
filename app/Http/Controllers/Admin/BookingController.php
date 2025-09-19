<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar semua booking.
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'package']) // Eager loading untuk efisiensi
            ->latest()
            ->paginate(10);
            
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Menampilkan detail satu booking.
     */
    public function show(Booking $booking)
    {
        // Load semua relasi untuk halaman detail
        $booking->load(['user', 'package', 'car']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Mengupdate status booking.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'pesan_confirm' => 'nullable|string', // Tambahkan validasi untuk pesan
        ]);

        $booking->update([
            'status' => $request->status,
            'pesan_confirm' => $request->pesan_confirm, // Simpan pesannya
        ]);

        return redirect()->route('admin.bookings.show', $booking)->with('success', 'Status booking berhasil diperbarui.');
    }

    /**
     * Menghapus data booking.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Data booking berhasil dihapus.');
    }
}