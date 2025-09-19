<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Category; // Ganti Package menjadi Category
use App\Models\Review; // Tambahkan ini

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Menampilkan halaman utama dengan daftar paket yang dikelompokkan per kategori.
     */
    public function index()
    {
        // Ambil semua KATEGORI yang memiliki setidaknya satu paket,
        // lalu sertakan (eager load) data paket-paket tersebut.
        $categories = Category::whereHas('packages')->with('packages')->get();
         $reviews = Review::orderBy('review_date', 'desc')->get();
        
        // Kirim data categories ke view
        return view('landing', compact('categories','reviews'));
    }
}