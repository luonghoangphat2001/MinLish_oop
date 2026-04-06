<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\ProfileEdit;
use App\Http\Controllers\GoogleController;
<<<<<<< HEAD
use App\Livewire\Learning\LearningSession;
=======
use App\Livewire\Learning\FlashCard;
use App\Livewire\Vocabulary\VocabularyIndex;
use App\Livewire\Dashboard\ProgressDashboard;
>>>>>>> 7ef4268b3ffbd68cac2db2a0eb2de9478d18e60b

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', ProgressDashboard::class)->name('dashboard');
    Route::get('profile', ProfileEdit::class)->name('profile');
    Route::view('vocabulary/sets', 'vocabulary.sets')->name('vocabulary.sets');
<<<<<<< HEAD
=======
    Route::get('vocabulary/sets/{set}/words', VocabularyIndex::class)->name('vocabulary.words');
    Route::get('learning/sets/{set}/flashcards', FlashCard::class)->name('learning.flashcards');
>>>>>>> 7ef4268b3ffbd68cac2db2a0eb2de9478d18e60b
});


Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

<<<<<<< HEAD
Route::get('/learning/session', LearningSession::class)->middleware('auth')->name('learning.session');

=======
>>>>>>> 7ef4268b3ffbd68cac2db2a0eb2de9478d18e60b
require __DIR__ . '/auth.php';
