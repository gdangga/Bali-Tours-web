@extends('layouts.public')

@section('content')
<div class="py-20">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="py-8 px-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Verifikasi Alamat Email Anda</h2>
            
            @if (session('message'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('message') }}
                </div>
            @endif

            <p class="text-gray-600 mb-6">
                Terima kasih telah mendaftar! Sebelum melanjutkan, silakan periksa email Anda dan klik link verifikasi yang telah kami kirim.
                <br><br>
                Jika Anda tidak menerima email, klik tombol di bawah untuk mengirim ulang.
            </p>

            <div class="flex items-center justify-center space-x-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 underline">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection