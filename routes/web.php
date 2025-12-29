<?php

use Illuminate\Support\Facades\Route;

// --- IMPORT COMPONENT LIVEWIRE ---
// Public Components
use App\Livewire\Public\LandingPage;
use App\Livewire\Public\SearchPage;
use App\Livewire\Public\SeriesPage;
use App\Livewire\Public\RankingPage;
use App\Livewire\Public\BookDetail;
use App\Livewire\Public\ReadChapter;

// Auth Components
use App\Livewire\Dashboard;

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
    
    // Dashboard Penulis (Menggunakan Livewire Component baru)
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Route Profile (Bawaan Laravel Breeze/Jetstream)
    // Anda bisa membiarkan ini default view 'profile'
    Route::view('profile', 'profile')->name('profile');
});


// ==========================================
// 3. AUTH SYSTEM ROUTES
// ==========================================
// Memuat route login, register, logout bawaan Laravel
require __DIR__.'/auth.php';