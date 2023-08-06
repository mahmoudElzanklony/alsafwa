<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {




        Inertia::share('user_personal_data', function () {
            if (Auth::user()) {
                return auth()->user();
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        app()->setLocale('ar');
        Schema::defaultStringLength(191);
        date_default_timezone_set('Africa/Cairo'); // set your default timezone

    }
}
