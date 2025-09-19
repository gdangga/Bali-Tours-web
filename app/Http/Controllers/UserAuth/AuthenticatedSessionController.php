<?php

namespace App\Http\Controllers\UserAuth; // <-- PASTIKAN INI BENAR

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Otp;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('user.auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            // 'g-recaptcha-response' => 'required|captcha',

        ]);

        // 1. Cek kredensial, tapi jangan login dulu
        if (!Auth::validate($credentials)) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
        }

        $user = \App\Models\User::where('email', $credentials['email'])->first();

        // 2. Hapus OTP lama jika ada
        Otp::where('identifier', $user->email)->delete();

        // 3. Buat OTP baru
        $otpCode = rand(100000, 999999);
        $otpRecord = Otp::create([
            'identifier' => $user->email,
            'token' => $otpCode,
            'expires_at' => now()->addMinutes(5), // OTP berlaku 5 menit
        ]);

        // 4. Kirim OTP ke email user
        Mail::to($user->email)->send(new SendOtpMail($otpCode));

        // 5. Simpan email di session dan redirect ke halaman OTP
        $request->session()->put('otp_email', $user->email);

        return redirect()->route('otp.create');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}