<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Booking;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bagikan data ke view layouts.public
        View::composer('layouts.public', function ($view) {
            if (Auth::check()) {
                $cartCount = Cart::where('user_id', auth()->id())->count();
                $bookingCount = Booking::where('user_id', auth()->id())->count();
            } else {
                $cartCount = 0;
                $bookingCount = 0;
            }
            $view->with('cartCount', $cartCount)->with('bookingCount', $bookingCount);
        });
    }
}
