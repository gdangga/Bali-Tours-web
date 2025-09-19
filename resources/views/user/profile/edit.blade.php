@extends('layouts.public')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="py-6 px-8">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Edit Profil Saya</h2>

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">No. HP / WhatsApp</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="country">Negara</label>
                    <input type="text" name="country" id="country" value="{{ old('country', $user->country) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @error('country')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <hr class="my-6">
                
                <p class="text-gray-600 text-sm mb-4">Kosongkan password jika Anda tidak ingin mengubahnya.</p>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password Baru</label>
                    <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <div class="flex items-center justify-end">
                    <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection