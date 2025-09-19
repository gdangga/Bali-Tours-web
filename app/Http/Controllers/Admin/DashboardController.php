<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Package;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan data monitoring.
     */
    public function index()
    {
        // Mengambil total data dari setiap model
        $packageCount = Package::count();
        $carCount = Car::count();
        $addonCount = Addon::count();
        $bookingCount = Booking::count(); // Ini akan menghitung dari tabel 'bookings'

        // Mengirim semua data ke view 'admin.dashboard'
        return view('admin.dashboard', compact(
            'packageCount',
            'carCount',
            'addonCount',
            'bookingCount'
        ));
    }
}