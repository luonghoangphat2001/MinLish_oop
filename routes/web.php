<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\ProfileEdit;
use App\Http\Controllers\GoogleController;
use App\Livewire\Learning\LearningSession;
use App\Livewire\Learning\FlashCard;
use App\Livewire\Vocabulary\VocabularyIndex;
use App\Livewire\Dashboard\ProgressDashboard;

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', ProgressDashboard::class)->name('dashboard');
    Route::get('profile', ProfileEdit::class)->name('profile');
    Route::view('vocabulary/sets', 'vocabulary.sets')->name('vocabulary.sets');
    Route::get('vocabulary/sets/{set}/words', VocabularyIndex::class)->name('vocabulary.words');
    Route::get('learning/sets/{set}/flashcards', FlashCard::class)->name('learning.flashcards');
    Route::get('learning/sets/{set}/context', \App\Livewire\Learning\ContextLearning::class)->name('learning.context');
});


Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/learning/session', LearningSession::class)->middleware('auth')->name('learning.session');

require __DIR__ . '/auth.php';
