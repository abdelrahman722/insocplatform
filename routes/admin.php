<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// admin route
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    
    // dashboard routes
    Route::get('dashboard', App\Livewire\Admin\Dashbord::class)->name('dashboard');

    // users routes
    Route::get('users', App\Livewire\Admin\Users\Index::class)->name('users.index');
    Route::get('users/create', App\Livewire\Admin\Users\Create::class)->name('users.create');
    Route::get('users/{id}/edit', App\Livewire\Admin\Users\Edit::class)->name('users.edit');

    // schools routes
    Route::get('schools', App\Livewire\Admin\Schools\Index::class)->name('schools.index');
    Route::get('schools/create', App\Livewire\Admin\Schools\Create::class)->name('schools.create');
    Route::get('schools/{id}/edit', App\Livewire\Admin\Schools\Edit::class)->name('schools.edit');
    Route::get('schools/{id}/show', App\Livewire\Admin\Schools\Show::class)->name('schools.show');

    // programs routes
    Route::get('programs', App\Livewire\Admin\Programs\Index::class)->name('programs.index');
    Route::get('programs/{id}/edit', App\Livewire\Admin\Programs\Edit::class)->name('programs.edit');

    // activations routes
    Route::get('activations', App\Livewire\Admin\Activations\Index::class)->name('activations.index');
    Route::get('activations/requests', App\Livewire\Admin\RequestActivation\Index::class)->name('activations.requests');

});