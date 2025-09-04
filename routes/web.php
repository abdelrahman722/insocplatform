<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;


// public route
Route::get('/', App\Livewire\LandingPage::class)->name('home');
Route::get('/request/activation', App\Livewire\Admin\RequestActivation\Create::class)->name('request.activation');

Route::middleware(['auth'])->group(function () {
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Volt::route('settings/lang', 'settings.lang')->name('settings.lang');
});

require __DIR__.'/auth.php';
require __DIR__.'/customer.php';
require __DIR__.'/admin.php';
