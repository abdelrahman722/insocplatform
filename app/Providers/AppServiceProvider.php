<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schedule;

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
        // تطبيق اللغة بناءً على المستخدم
        if (Auth::check()) {
            App::setLocale(Auth::user()->lang);
        }
        Schedule::command('activations:expire')->daily();
    }
}
