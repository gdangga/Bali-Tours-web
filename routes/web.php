<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PackageController; // Controller publik untuk paket
use App\Http\Controllers\UserAuth\AuthenticatedSessionController;
use App\Http\Controllers\UserAuth\RegisteredUserController;
use App\Http\Controllers\UserAuth\OtpController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\AddonController as AdminAddonController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Auth\AuthController; // Controller login admin
use App\Http\Controllers\UserAuth\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserBookingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// == ROUTE UNTUK PENGUNJUNG & USER BIASA ==
Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/packages/{package}', [PackageController::class, 'show'])->name('packages.show');

// Grup Route untuk Autentikasi User (Tamu)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('verify-otp', [OtpController::class, 'create'])->name('otp.create');
    Route::post('verify-otp', [OtpController::class, 'store'])->name('otp.store');
});

// Grup Route untuk Autentikasi User (yang sudah login)
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Tambahkan dua baris ini
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Route untuk Verifikasi Email
    Route::get('/email/verify', function () {
        return view('user.auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link verifikasi baru telah dikirim!');
    })->middleware('throttle:6,1')->name('verification.send');

    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/cart/add', [BookingController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/{cart}/delete', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/my-bookings', [UserBookingController::class, 'index'])->name('bookings.index');
    Route::get('/my-bookings/{booking}', [UserBookingController::class, 'show'])->name('bookings.show');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/booking/pay', [BookingController::class, 'pay'])->name('booking.pay');


    
});


Route::prefix('admin')->group(function () {
    // Rute Autentikasi Admin
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('login', [AuthController::class, 'generateOtp'])->name('admin.login.generate');
    Route::get('verify-otp', [AuthController::class, 'showVerifyForm'])->name('admin.login.verify.form');
    Route::post('verify-otp', [AuthController::class, 'verifyOtp'])->name('admin.login.verify');
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Grup untuk dashboard admin yang sudah login
    Route::middleware('auth')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('packages', AdminPackageController::class);
        Route::delete('packages/gallery/{image}', [AdminPackageController::class, 'destroyImage'])->name('packages.gallery.destroy');
        Route::resource('cars', AdminCarController::class);
        Route::resource('addons', AdminAddonController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
        Route::patch('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
        Route::delete('bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
    });
});

Route::post('/midtrans/notification', [MidtransController::class, 'notification'])->name('midtrans.notification');
Route::get('/packages/{package}', [PackagesController::class, 'show'])
    ->name('packages.show');