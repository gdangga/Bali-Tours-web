@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        <div class="mb-6">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori:</label>
            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name', $category->name) }}" required>
            @error('name')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-start">
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                Update Kategori
            </button>
            <a href="{{ route('admin.categories.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">Batal</a>
        </div>
    </form>
@endsection