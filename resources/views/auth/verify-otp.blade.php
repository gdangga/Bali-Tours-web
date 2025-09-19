<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi OTP</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-center">Verifikasi Kode OTP</h2>
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                  {{ session('success') }}
                </div>
            @endif
            <p class="text-center text-gray-600">Masukkan 6 digit kode yang dikirim ke <strong>{{ $email }}</strong>.</p>
            <form method="POST" action="{{ route('admin.login.verify') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <div>
                    <label for="token" class="block mb-2 text-sm font-medium text-gray-900">Kode OTP</label>
                    <input type="text" name="token" id="token" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                     @error('token') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="w-full mt-4 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Verifikasi & Login</button>
            </form>
        </div>
    </div>
</body>
</html>