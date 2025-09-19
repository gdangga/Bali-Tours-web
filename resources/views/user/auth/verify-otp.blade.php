@extends('layouts.public')
@section('content')
<div class="py-20">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="py-8 px-6">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Verifikasi Dua Langkah</h2>
            <p class="text-center text-gray-600 mb-6">Kami telah mengirimkan 6 digit kode ke email Anda. Silakan masukkan di bawah ini.</p>
            
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('otp.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="otp" class="block text-gray-700 text-sm font-bold mb-2">Kode OTP</label>
                    <input type="text" name="otp" id="otp" required autofocus class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 text-center tracking-[1em]">
                </div>
                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">Verifikasi</button>
            </form>
        </div>
    </div>
</div>
@endsection