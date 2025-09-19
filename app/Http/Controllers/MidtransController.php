<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function notification(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            // Buat instance notifikasi
            $notification = new Notification();

            $status = $notification->transaction_status;
            $orderId = $notification->order_id;
            
            // Ekstrak ID booking dari order_id
            $bookingId = explode('-', $orderId)[1];
            $booking = Booking::findOrFail($bookingId);

            // Update status booking berdasarkan notifikasi
            if ($status == 'settlement' || $status == 'capture') {
                $booking->update(['payment_status' => 'paid']);
            } else if ($status == 'pending') {
                $booking->update(['payment_status' => 'pending']);
            } else if ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
                $booking->update(['payment_status' => 'failed']);
            }

            return response()->json(['message' => 'Notification handled successfully.']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}