<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered; // <-- Tambahkan 'use' statement ini

class RegisteredUserController extends Controller
{
    /** Menampilkan halaman registrasi. */
    public function create()
    {
        return view('user.auth.register');
    }

    /** Menyimpan data user baru. */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // 'g-recaptcha-response' => 'required|captcha',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'password' => Hash::make($request->password),
        ]);

        // LANGKAH 1: Picu event untuk mengirim email verifikasi
        // Baris ini akan menyuruh Laravel mengirim email aktivasi.
        event(new Registered($user));

        Auth::login($user);

        // LANGKAH 2: Arahkan ke halaman notifikasi verifikasi, bukan ke landing page
        return redirect()->route('verification.notice');
    }
}