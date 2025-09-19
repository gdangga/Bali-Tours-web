<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AddonController extends Controller
{
    public function index()
    {
        $addons = Addon::latest()->paginate(10);
        return view('admin.addons.index', compact('addons'));
    }

    public function create()
    {
        return view('admin.addons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('addon_images', 'public');
        }

        Addon::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.addons.index')->with('success', 'Addon berhasil ditambahkan.');
    }

    public function edit(Addon $addon)
    {
        return view('admin.addons.edit', compact('addon'));
    }

    public function update(Request $request, Addon $addon)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $addonData = $request->only('name', 'description', 'price');

        if ($request->hasFile('image')) {
            if ($addon->image) {
                Storage::disk('public')->delete($addon->image);
            }
            $addonData['image'] = $request->file('image')->store('addon_images', 'public');
        }

        $addon->update($addonData);

        return redirect()->route('admin.addons.index')->with('success', 'Addon berhasil diperbarui.');
    }

    public function destroy(Addon $addon)
    {
        if ($addon->image) {
            Storage::disk('public')->delete($addon->image);
        }
        $addon->delete();

        return redirect()->route('admin.addons.index')->with('success', 'Addon berhasil dihapus.');
    }
}