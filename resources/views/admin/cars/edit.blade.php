@extends('layouts.admin')

@section('title', 'Edit Mobil')

@section('content')
    <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Mobil:</label>
            <input type="text" name="name" value="{{ old('name', $car->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        </div>
        <div class="mb-4">
            <label for="capacity" class="block text-gray-700 text-sm font-bold mb-2">Kapasitas (orang):</label>
            <input type="number" name="capacity" value="{{ old('capacity', $car->capacity) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        </div>
        <div class="mb-4">
            <label for="price_per_day" class="block text-gray-700 text-sm font-bold mb-2">Harga / Hari (Rp):</label>
            <input type="number" name="price_per_day" value="{{ old('price_per_day', $car->price_per_day) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Gambar Saat Ini:</label>
            <img src="{{ Storage::url($car->image) }}" alt="Car Image" class="h-32 w-auto rounded shadow">
        </div>
        <div class="mb-6">
            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Ganti Gambar (opsional):</label>
            <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
        </div>
        <div class="flex items-center justify-start">
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                Update Mobil
            </button>
            <a href="{{ route('admin.cars.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">Batal</a>
        </div>
    </form>
@endsection