<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Car;
use App\Models\Package;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    /**
     * Menampilkan halaman detail untuk satu paket.
     */
    public function show(Package $package)
    {
        $package->load('options', 'images', 'category');
        $cars = Car::all();
        $addons = Addon::all(); // Jika masih diperlukan
        return view('packages.show', compact('package', 'cars', 'addons'));
    }
}