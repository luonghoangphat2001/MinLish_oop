<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\ProfileEdit;
use App\Http\Controllers\GoogleController;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('profile', ProfileEdit::class)->name('profile');
    Route::view('vocabulary/sets', 'vocabulary.sets')->name('vocabulary.sets');
});


Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

require __DIR__ . '/auth.php';
