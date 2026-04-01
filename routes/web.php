<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\ProfileEdit;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('profile', ProfileEdit::class)->name('profile');
});

require __DIR__.'/auth.php';
