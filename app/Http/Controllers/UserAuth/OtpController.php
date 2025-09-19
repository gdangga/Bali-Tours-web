<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function create()
    {
        return view('user.auth.verify-otp');
    }

    public function store(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $email = $request->session()->get('otp_email');
        if (!$email) {
            return redirect()->route('login')->withErrors(['email' => 'Sesi telah berakhir, silakan login kembali.']);
        }

        $otpRecord = Otp::where('identifier', $email)->where('token', $request->otp)->first();

        if (!$otpRecord || now()->gt($otpRecord->expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau telah kedaluwarsa.']);
        }
        
        $user = User::where('email', $email)->first();
        Auth::login($user);
        $otpRecord->delete(); // Hapus OTP setelah berhasil digunakan
        $request->session()->regenerate();

        return redirect()->intended('/');
    }
}