@extends('layouts.public')

@section('content')
<div class="py-12">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="py-4 px-6">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Buat Akun Baru</h2>
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Oops!</strong>
                    <ul class="mt-3 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nama</label><input type="text" name="name" id="name" value="{{ old('name') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></div>
                <div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label><input type="email" name="email" id="email" value="{{ old('email') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></div>
                <div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2" for="phone">No. HP / WhatsApp</label><input type="text" name="phone" id="phone" value="{{ old('phone') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></div>
                <div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2" for="country">Negara</label><input type="text" name="country" id="country" value="{{ old('country') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></div>
                <div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label><input type="password" name="password" id="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></div>
                <div class="mb-6"><label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">Konfirmasi Password</label><input type="password" name="password_confirmation" id="password_confirmation" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></div>
                {{-- <div class="mb-4">
                    {!! NoCaptcha::display() !!}
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="text-red-500 text-xs mt-1">{{ $errors->first('g-recaptcha-response') }}</span>
                    @endif
                </div> --}}
                <div class="flex items-center justify-between">
                    <a class="inline-block align-baseline font-bold text-sm text-orange-500 hover:text-orange-800" href="{{ route('login') }}">Sudah punya akun?</a>
                    <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded" type="submit">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection