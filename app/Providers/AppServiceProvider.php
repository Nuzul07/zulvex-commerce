<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        Inertia::share([
            'user_auth' => function () {
                return Auth::user();
            },
            'wishlist_count' => function () {
                return Wishlist::count();
            },
            'cart_count' => function () {
                return Cart::count();
            },
        ]);
    }
}
