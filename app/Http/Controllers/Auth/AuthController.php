<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp; // Kita perlu buat model ini
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail; // Kita perlu buat Mailable ini
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function generateOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->where('role', 'admin')->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Admin dengan email ini tidak ditemukan.']);
        }

        $otpCode = rand(100000, 999999);

        $otp = Otp::updateOrCreate(
            ['identifier' => $request->email],
            [
                'token' => $otpCode,
                'expires_at' => now()->addMinutes(10)
            ]
        );

        // Kirim email (akan kita buat Mailable-nya)
        Mail::to($request->email)->send(new SendOtpMail($otpCode));

        return redirect()->route('admin.login.verify.form', ['email' => $request->email])
                         ->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function showVerifyForm(Request $request)
    {
        return view('auth.verify-otp', ['email' => $request->email]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|numeric'
        ]);

        $otp = Otp::where('identifier', $request->email)
                    ->where('token', $request->token)
                    ->where('expires_at', '>', now())
                    ->first();

        if (!$otp) {
            return back()->withErrors(['token' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            Auth::login($user);
            $otp->delete(); // Hapus OTP setelah berhasil digunakan
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard'); // Arahkan ke dashboard
        }

        return back()->withErrors(['email' => 'Gagal melakukan autentikasi.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}