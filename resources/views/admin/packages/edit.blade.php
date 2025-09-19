@extends('layouts.admin')

@section('title', 'Edit Paket: ' . $package->name)

@section('content')
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- FORM UTAMA UNTUK UPDATE DATA PAKET --}}
    <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md mb-8">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Paket:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $package->name) }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
        </div>
        <div class="mb-4">
             <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Kategori Paket:</label>
             <select name="category_id" id="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                 <option value="">Pilih Kategori</option>
                 @foreach($categories as $category)
                     <option value="{{ $category->id }}" @selected(old('category_id', $package->category_id) == $category->id)>{{ $category->name }}</option>
                 @endforeach
             </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Tipe Harga:</label>
            <div class="flex items-center">
                <input type="radio" name="pricing_type" id="per_person" value="per_person" class="mr-2" @checked(old('pricing_type', $package->pricing_type) == 'per_person')><label for="per_person" class="mr-6">Per Orang</label>
                <input type="radio" name="pricing_type" id="per_group" value="per_group" class="mr-2" @checked(old('pricing_type', $package->pricing_type) == 'per_group')><label for="per_group">Per Grup / Mobil</label>
            </div>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Lengkap:</label>
            <textarea name="description" id="description" class="ckeditor">{{ old('description', $package->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label for="highlights" class="block text-gray-700 text-sm font-bold mb-2">Sorotan Utama (Highlights):</label>
            <textarea name="highlights" id="highlights" class="ckeditor">{{ old('highlights', $package->highlights) }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Thumbnail Saat Ini:</label>
            <img src="{{ Storage::url($package->thumbnail) }}" alt="Thumbnail" class="h-32 w-auto object-cover rounded shadow">
        </div>
        <div class="mb-4">
            <label for="thumbnail" class="block text-gray-700 text-sm font-bold mb-2">Ganti Thumbnail :</label>
            <input type="file" name="thumbnail" id="thumbnail" class="shadow border rounded w-full py-2 px-3 text-gray-700">
        </div>
        

        <hr class="my-6">

        <div x-data="{ options: {{ $package->options->isNotEmpty() ? $package->options->toJson() : "[{ name: '', price: '', description: '' }]" }} }">
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
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded">Update Paket</button>

        <div class="mb-6 mt-6">
                <label for="gallery" class="block text-gray-700 text-sm font-bold mb-2">Tambah Gambar Galeri (opsional) Kelola Galery di bawah:</label>
                <input type="file" name="gallery[]" id="gallery" class="shadow border rounded w-full py-2 px-3 text-gray-700" multiple>
            </div>
    </form>
    {{-- AKHIR DARI FORM UTAMA --}}


    {{-- BAGIAN TERPISAH UNTUK MENGELOLA GALERI YANG ADA --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-bold text-gray-700 mb-4">Kelola Galeri Saat Ini</h3>
        @if($package->images->isNotEmpty())
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($package->images as $image)
                    <div class="relative group">
                        <img src="{{ Storage::url($image->image_path) }}" alt="Gallery Image" class="h-32 w-full object-cover rounded-md shadow-lg">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-md">
                            {{-- Setiap tombol hapus adalah form-nya sendiri --}}
                            <form action="{{ route('admin.packages.gallery.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white text-sm bg-red-600 hover:bg-red-700 rounded-full p-2" title="Hapus Gambar">
                                    <svg xmlns="http://www.w.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">Belum ada gambar galeri.</p>
        @endif
    </div>
@endsection