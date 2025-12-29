<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Livewire Components
use App\Livewire\Public\LandingPage;
use App\Livewire\Public\SearchPage;
use App\Livewire\Public\SeriesPage;
use App\Livewire\Public\RankingPage;
use App\Livewire\Public\BookDetail;
use App\Livewire\Public\ReadChapter;
use App\Livewire\Dashboard;
use App\Livewire\ManageBook;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- PUBLIC ROUTES ---
Route::get('/', LandingPage::class)->name('home');
Route::get('/search', SearchPage::class)->name('search');
Route::get('/series', SeriesPage::class)->name('series');
Route::get('/ranking', RankingPage::class)->name('ranking');
Route::get('/book/{id}', BookDetail::class)->name('book.detail');
Route::get('/chapter/{id}', ReadChapter::class)->name('chapter.read');

// --- AUTHENTICATED ROUTES ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard (Livewire: Tanpa kurung siku)
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Manage Book (Livewire: Tanpa kurung siku)
    Route::get('/book/manage/{id?}', ManageBook::class)->name('book.manage');

    // Profile (Controller Biasa: WAJIB pakai kurung siku)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';