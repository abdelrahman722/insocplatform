<?php

use Illuminate\Support\Facades\Route;

// customer route

Route::middleware('auth')->group(function () {
    Route::middleware('role:manager')->group(function () {

        Route::get('manager/actvation', App\Livewire\Manager\Actvation::class)->name('manager.actvation');
        Route::get('manager/', App\Livewire\Manager\Dashbord::class)->name('manager.dashboard');
    });
});

Route::middleware(['auth', 'school.active'])->group(function () {

    // school manager route
    Route::middleware('role:manager')->group(function () {

        
        Route::get('/manager/import', App\Livewire\Manager\ImportExcel::class)->name('manager.import');

        // users routes
        Route::get('manager/users', App\Livewire\Manager\Users\Index::class)->name('manager.users.index');
        Route::get('manager/users/{id}/edit', App\Livewire\Manager\Users\Edit::class)->name('manager.users.edit');
    
        // students routes
        Route::get('manager/students', App\Livewire\Manager\Students\Index::class)->name('manager.students.index');
        Route::get('manager/students/create', App\Livewire\Manager\Students\Create::class)->name('manager.students.create');
        Route::get('manager/students/{id}/edit', App\Livewire\Manager\Students\Edit::class)->name('manager.students.edit');
    
        // Guardians routes
        Route::get('manager/guardians', App\Livewire\Manager\Guardians\Index::class)->name('manager.guardians.index');
        Route::get('manager/guardians/create', App\Livewire\Manager\Guardians\Create::class)->name('manager.guardians.create');
        Route::get('manager/guardians/{id}/edit', App\Livewire\Manager\Guardians\Edit::class)->name('manager.guardians.edit');
    
        // Teachers routes
        Route::get('manager/teachers', App\Livewire\Manager\Teachers\Index::class)->name('manager.teachers.index');
        Route::get('manager/teachers/create', App\Livewire\Manager\Teachers\Create::class)->name('manager.teachers.create');
        Route::get('manager/teachers/{id}/edit', App\Livewire\Manager\Teachers\Edit::class)->name('manager.teachers.edit');
    });

    // guardian route
    Route::middleware('role:guardian')->group(function(){
        Route::get('/guardian', App\Livewire\Guardian\Dashboard::class)->name('guardian.dashboard');
        Route::get('/guardian/book-meeting', App\Livewire\Guardian\BookMeeting::class)->name('guardian.book-meeting');
        Route::get('/guardian/chat', App\Livewire\Guardian\Chat::class)->name('guardian.chat');
    });

    // teacher route
    Route::middleware('role:teacher')->group(function () {

        Route::get('teacher/', App\Livewire\Teacher\Dashboard::class)->name('teacher.dashboard');
        Route::get('/teacher/set-slots', App\Livewire\Teacher\SetAvailableSlots::class)->name('teacher.set-slots');
        Route::get('/teacher/manage-meeting', App\Livewire\Teacher\ManageMeetings::class)->name('teacher.manage-meeting');
    });
});

