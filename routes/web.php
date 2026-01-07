<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController; 

// --- 1. IMPORT LIVEWIRE PUBLIC COMPONENTS ---
use App\Livewire\Public\LandingPage;
use App\Livewire\Public\SearchPage;
use App\Livewire\Public\SeriesPage;
use App\Livewire\Public\RankingPage;
use App\Livewire\Public\BookDetail;
use App\Livewire\Public\ReadChapter;

// --- 2. IMPORT LIVEWIRE ADMIN COMPONENTS ---
use App\Livewire\Dashboard;
// Pastikan nama class JAMAK (ManageBooks) dan namespace ADMIN
use App\Livewire\Admin\ManageBooks;  
use App\Livewire\Admin\ChapterEditor;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', LandingPage::class)->name('home');
Route::get('/search', SearchPage::class)->name('search');
Route::get('/series', SeriesPage::class)->name('series');
Route::get('/ranking', RankingPage::class)->name('ranking');
Route::get('/book/{id}', BookDetail::class)->name('book.detail');
Route::get('/chapter/{id}', ReadChapter::class)->name('chapter.read');

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // [PENTING] Tambahkan tanda tanya {id?} agar bisa diakses tanpa ID (untuk Buat Baru)
    Route::get('/book/manage/{id?}', ManageBooks::class)->name('book.manage');

    // Route untuk Chapter
    Route::get('/book/{bookId}/chapters', ChapterEditor::class)->name('book.chapters');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';