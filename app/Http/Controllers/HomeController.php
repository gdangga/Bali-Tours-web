<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman depan (landing page) dengan semua paket tour.
     */
    public function index()
    {
        $packages = Package::latest()->get();
        return view('landing', compact('packages'));
    }
}