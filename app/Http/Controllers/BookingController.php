<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cart;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $request->validate(['package_id' => 'required|exists:packages,id']);
        $package = Package::with('options')->findOrFail($request->package_id);
        $selectedData = [
            'option_id' => $request->option_id,
            'tour_date' => $request->tour_date,
            'num_people' => $request->num_people ?? 1,
        ];
        return view('booking.create', compact('package', 'selectedData'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'package_option_id' => 'required|exists:package_options,id',
            'tour_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required|date_format:H:i', // <-- Add this
            'pickup_location' => 'required|string',     // <-- Add this
            'num_people' => 'required|integer|min:1',
            'total_price' => 'required|numeric',
            'participants' => 'required|json',
            'payment_method' => 'required|string|in:cash,gateway',
            'notes' => 'nullable|string',
        ]);
        
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'package_id' => $validated['package_id'],
            'tour_date' => $validated['tour_date'],
            'pickup_time' => $validated['pickup_time'],         // <-- Add this
            'pickup_location' => $validated['pickup_location'], // <-- Add this
            'num_people' => $validated['num_people'],
            'participants' => json_decode($validated['participants']),
            'total_price' => $validated['total_price'],
            'payment_method' => $validated['payment_method'],
            'notes' => $validated['notes'],
            'payment_status' => 'pending',
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully! It is now on your booking list.');
    }

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'package_option_id' => 'required|exists:package_options,id',
            'tour_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required|date_format:H:i', // <-- Add this
            'pickup_location' => 'required|string',     // <-- Add this
            'num_people' => 'required|integer|min:1',
            'total_price' => 'required|numeric',
            'participants' => 'nullable|json',
            'notes' => 'nullable|string',
        ]);

        Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'package_id' => $validated['package_id'],
                'package_option_id' => $validated['package_option_id'],
            ],
            [
                'tour_date' => $validated['tour_date'],
                'pickup_time' => $validated['pickup_time'],         // <-- Add this
                'pickup_location' => $validated['pickup_location'], // <-- Add this
                'num_people' => $validated['num_people'],
                'total_price' => $validated['total_price'],
                'participants' => $validated['participants'],
                'notes' => $validated['notes'],
            ]
        );

        return redirect()->route('cart.index')->with('success', 'Package added to cart successfully!');

    }

    public function pay(Request $request)
    {
        try {
            // Validasi sama seperti method store
            $validated = $request->validate([
                'package_id' => 'required|exists:packages,id',
                'package_option_id' => 'required|exists:package_options,id',
                'tour_date' => 'required|date|after_or_equal:today',
                'pickup_time' => 'required|date_format:H:i',
                'pickup_location' => 'required|string',
                'num_people' => 'required|integer|min:1',
                'total_price' => 'required|numeric',
                'participants' => 'required|json',
                'notes' => 'nullable|string',
            ]);
            
            // Buat booking di database
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'package_id' => $validated['package_id'],
                // Pastikan package_option_id juga disimpan jika ada relasinya
                // 'package_option_id' => $validated['package_option_id'],
                'tour_date' => $validated['tour_date'],
                'pickup_time' => $validated['pickup_time'],
                'pickup_location' => $validated['pickup_location'],
                'num_people' => $validated['num_people'],
                'participants' => json_decode($validated['participants']),
                'total_price' => $validated['total_price'],
                'payment_method' => 'midtrans', // Set metode pembayaran
                'notes' => $validated['notes'],
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            // Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;
            
            // Buat parameter untuk Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => 'BOOKING-' . $booking->id . '-' . time(), // Order ID unik
                    'gross_amount' => $booking->total_price,
                ],
                'customer_details' => [
                    'first_name' => $booking->user->name,
                    'email' => $booking->user->email,
                    // 'phone' => $booking->user->phone, // Pastikan user punya kolom phone
                ],
            ];

            \Midtrans\Config::$curlOptions = [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ];

            // Dapatkan Snap Token
            $snapToken = Snap::getSnapToken($params);

            // Kembalikan token sebagai JSON response
            return response()->json(['snap_token' => $snapToken]);

        } catch (ValidationException $e) {
            // Jika validasi gagal, kembalikan error sebagai JSON dengan status 422
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Untuk error lainnya, kembalikan pesan error umum sebagai JSON
            return response()->json([
                'message' => $e->getMessage(), 
                'file' => $e->getFile(),       
                'line' => $e->getLine()        
            ], 500);
        }
    }
}