@extends('layouts.admin')

@section('title', 'Edit Addon')

@section('content')
    <form action="{{ route('admin.addons.update', $addon->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Addon:</label>
            <input type="text" name="name" value="{{ old('name', $addon->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (opsional):</label>
            <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">{{ old('description', $addon->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp):</label>
            <input type="number" name="price" value="{{ old('price', $addon->price) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
        </div>
        @if($addon->image)
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Gambar Saat Ini:</label>
            <img src="{{ Storage::url($addon->image) }}" alt="Addon Image" class="h-32 w-auto rounded shadow">
        </div>
        @endif
        <div class="mb-6">
            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Ganti Gambar (opsional):</label>
            <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
        </div>
        <div class="flex items-center justify-start">
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                Update Addon
            </button>
            <a href="{{ route('admin.addons.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">Batal</a>
        </div>
    </form>
@endsection