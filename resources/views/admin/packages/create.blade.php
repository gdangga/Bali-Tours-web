@extends('layouts.admin')

@section('title', 'Tambah Paket Baru')

@section('content')
    <script src="//unpkg.com/alpinejs" defer></script>

    <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Paket:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
        </div>
        <div class="mb-4">
             <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Kategori Paket:</label>
             <select name="category_id" id="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                 <option value="">Pilih Kategori</option>
                 @foreach($categories as $category)
                     <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                 @endforeach
             </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Tipe Harga:</label>
            <div class="flex items-center">
                <input type="radio" name="pricing_type" id="per_person" value="per_person" class="mr-2" checked><label for="per_person" class="mr-6">Per Orang</label>
                <input type="radio" name="pricing_type" id="per_group" value="per_group" class="mr-2"><label for="per_group">Per Grup / Mobil</label>
            </div>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Lengkap:</label>
            <textarea name="description" id="description" class="ckeditor">{{ old('description') }}</textarea>
        </div>
        <div class="mb-4">
            <label for="highlights" class="block text-gray-700 text-sm font-bold mb-2">Sorotan Utama (Highlights):</label>
            <textarea name="highlights" id="highlights" class="ckeditor">{{ old('highlights') }}</textarea>
        </div>
        <div class="mb-4">
            <label for="thumbnail" class="block text-gray-700 text-sm font-bold mb-2">Thumbnail Utama:</label>
            <input type="file" name="thumbnail" id="thumbnail" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
        </div>
        <div class="mb-6">
            <label for="gallery" class="block text-gray-700 text-sm font-bold mb-2">Gambar Galeri (bisa pilih banyak):</label>
            <input type="file" name="gallery[]" id="gallery" class="shadow border rounded w-full py-2 px-3 text-gray-700" multiple>
        </div>

        <hr class="my-6">

        <div x-data="{ options: [{ name: '', price: '', description: '' }] }">
            <label class="block text-gray-700 text-lg font-bold mb-2">Opsi Paket & Harga</label>
            <template x-for="(option, index) in options" :key="index">
                <div class="border p-4 rounded-md mb-4 bg-gray-50">
                    <p class="font-semibold mb-2" x-text="'Opsi ' + (index + 1)"></p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Opsi</label>
                            <input type="text" :name="'options[' + index + '][name]'" x-model="option.name" class="mt-1 block w-full rounded-md border-gray-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                            <input type="number" :name="'options[' + index + '][price]'" x-model="option.price" class="mt-1 block w-full rounded-md border-gray-300" required>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Deskripsi/Itinerary Singkat (Opsional)</label>
                        <textarea :name="'options[' + index + '][description]'" x-model="option.description" rows="2" class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                    </div>
                    <div class="text-right mt-2">
                        <button type="button" x-show="options.length > 1" @click="options.splice(index, 1)" class="text-red-500 hover:text-red-700 text-sm">Hapus Opsi</button>
                    </div>
                </div>
            </template>
            <button type="button" @click="options.push({ name: '', price: '', description: '' })" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-sm">+ Tambah Opsi Lain</button>
        </div>
        
        <hr class="my-6">
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded">Simpan Paket</button>
    </form>
@endsection