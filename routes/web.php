<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController; 

// --- IMPORT COMPONENT LIVEWIRE ---

// 1. Public Components
use App\Livewire\Public\LandingPage;
use App\Livewire\Public\SearchPage;
use App\Livewire\Public\SeriesPage;
use App\Livewire\Public\RankingPage;
use App\Livewire\Public\BookDetail;
use App\Livewire\Public\ReadChapter;

// 2. Auth/Admin Components
use App\Livewire\Dashboard;
use App\Livewire\ManageBook; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. PUBLIC ROUTES (Dapat diakses Tamu)
// ==========================================

// Halaman Utama
Route::get('/', LandingPage::class)->name('home');

// Halaman Pencarian
Route::get('/search', SearchPage::class)->name('search');

// Halaman Series (Library)
Route::get('/series', SeriesPage::class)->name('series');

// Halaman Ranking
Route::get('/ranking', RankingPage::class)->name('ranking');

// Detail Buku
Route::get('/book/{id}', BookDetail::class)->name('book.detail');

// Baca Chapter
Route::get('/chapter/{id}', ReadChapter::class)->name('chapter.read');


// ==========================================
// 2. AUTHENTICATED ROUTES (Harus Login)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Penulis
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Manage Book (Create & Edit)
    // Parameter {id?} opsional: 
    // - Jika kosong = Mode Buat Baru
    // - Jika ada ID = Mode Edit
    Route::get('/book/manage/{id?}', ManageBook::class)->name('book.manage');

    // Profile Routes (Standard Laravel Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ==========================================
// 3. AUTH SYSTEM ROUTES
// ==========================================
require __DIR__.'/auth.php';