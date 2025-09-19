<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::latest()->paginate(10);
        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        return view('admin.cars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('car_images', 'public');

        Car::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'price_per_day' => $request->price_per_day,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.cars.index')->with('success', 'Data mobil berhasil ditambahkan.');
    }

    public function edit(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $carData = $request->only('name', 'capacity', 'price_per_day');

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($car->image);
            $carData['image'] = $request->file('image')->store('car_images', 'public');
        }

        $car->update($carData);

        return redirect()->route('admin.cars.index')->with('success', 'Data mobil berhasil diperbarui.');
    }

    public function destroy(Car $car)
    {
        Storage::disk('public')->delete($car->image);
        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Data mobil berhasil dihapus.');
    }
}