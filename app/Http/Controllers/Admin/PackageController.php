<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\PackageImage;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('category')->latest()->paginate(10);
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.packages.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'highlights' => 'nullable|string', // Validasi baru
            'category_id' => 'required|exists:categories,id',
            'pricing_type' => 'required|in:per_person,per_group',
            'thumbnail' => 'required|image|max:2048',
            'options' => 'required|array|min:1',
            'options.*.name' => 'required|string|max:255',
            'options.*.price' => 'required|numeric|min:0',
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('package_thumbnails', 'public');

        $package = Package::create([
            'name' => $request->name,
            'description' => $request->description,
            'highlights' => $request->highlights, // Simpan data baru
            'category_id' => $request->category_id,
            'pricing_type' => $request->pricing_type,
            'thumbnail' => $thumbnailPath,
        ]);

        if ($request->has('options')) {
            foreach ($request->options as $optionData) {
                $package->options()->create($optionData);
            }
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $galleryPath = $image->store('package_gallery', 'public');
                $package->images()->create(['image_path' => $galleryPath]);
            }
        }

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(Package $package)
    {
        $categories = Category::all();
        $package->load('options');
        return view('admin.packages.edit', compact('package', 'categories'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'highlights' => 'nullable|string', // Validasi baru
            'category_id' => 'required|exists:categories,id',
            'pricing_type' => 'required|in:per_person,per_group',
            'thumbnail' => 'nullable|image|max:2048',
            'options' => 'required|array|min:1',
            'options.*.name' => 'required|string|max:255',
            'options.*.price' => 'required|numeric|min:0',
        ]);

        $packageData = $request->only('name', 'description', 'highlights', 'category_id', 'pricing_type');

        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($package->thumbnail);
            $packageData['thumbnail'] = $request->file('thumbnail')->store('package_thumbnails', 'public');
        }

        $package->update($packageData);

        // Hapus opsi lama, buat ulang dari data baru
        $package->options()->delete();
        if ($request->has('options')) {
            foreach ($request->options as $optionData) {
                $package->options()->create($optionData);
            }
        }
        
        if ($request->hasFile('gallery')) {
            // Logika untuk hapus gambar galeri lama bisa ditambahkan di sini jika perlu
            foreach ($request->file('gallery') as $image) {
                $galleryPath = $image->store('package_gallery', 'public');
                $package->images()->create(['image_path' => $galleryPath]);
            }
        }

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(Package $package)
    {
        Storage::disk('public')->delete($package->thumbnail);
        foreach ($package->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil dihapus.');
    }

    // TAMBAHKAN METHOD BARU DI BAWAH INI
    /**
     * Menghapus gambar galeri dari paket.
     */
    public function destroyImage(PackageImage $image)
    {
        // 1. Hapus file fisik dari storage
        Storage::disk('public')->delete($image->image_path);

        // 2. Hapus record dari database
        $image->delete();

        // 3. Kembali ke halaman edit dengan pesan sukses
        return back()->with('success', 'Gambar galeri berhasil dihapus.');
    }
}