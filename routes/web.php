<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Import Livewire Components
use App\Livewire\Public\LandingPage;
use App\Livewire\Public\BookDetail;
use App\Livewire\Public\ReadChapter;
use App\Livewire\Admin\ManageBooks;
use App\Livewire\Admin\ChapterEditor;
use App\Livewire\Public\SearchPage;
// use App\Livewire\Public\SeriesPage;
// use App\Livewire\Public\RankingPage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ====================================================
// 1. PUBLIC ROUTES (Bisa diakses Tanpa Login)
// ====================================================

// Halaman Depan (Landing Page)
Route::get('/', LandingPage::class)->name('home');

// Halaman Detail Buku
// PERBAIKAN: Mengubah nama route dari 'book.show' menjadi 'book.detail'
Route::get('/book/{id}', BookDetail::class)->name('book.detail');

// Halaman Baca Chapter
Route::get('/read/{id}', ReadChapter::class)->name('chapter.read');

// ROUTE BARU UNTUK PENCARIAN
Route::get('/search', SearchPage::class)->name('search');

// Route::get('/series', SeriesPage::class)->name('series');
// Route::get('/ranking', RankingPage::class)->name('ranking');


// ====================================================
// 2. AUTHOR / ADMIN ROUTES (Wajib Login)
// ====================================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Utama 
    Route::get('/dashboard', ManageBooks::class)->name('dashboard');

    // Halaman Editor Menulis
    Route::get('/write/{bookId}', ChapterEditor::class)->name('admin.chapters');
});


// ====================================================
// 3. PROFILE ROUTES (Bawaan Laravel Breeze)
// ====================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




// ====================================================
// 4. AUTH ROUTES (Login, Register, Logout)
// ====================================================
require __DIR__.'/auth.php';