<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// --- IMPORT LIVEWIRE COMPONENTS ---

// 1. Public Components (Halaman Depan)
use App\Livewire\Public\LandingPage;
use App\Livewire\Public\SearchPage;
use App\Livewire\Public\SeriesPage;
use App\Livewire\Public\RankingPage;
use App\Livewire\Public\BookDetail;
use App\Livewire\Public\ReadChapter;

// 2. Auth/Author Components (Halaman Admin/Penulis)
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
    // PENTING: Jangan gunakan tanda kurung siku [] di sini untuk Livewire Full Page Component
    Route::get('/book/manage/{id?}', ManageBook::class)->name('book.manage');

    // Profile Routes (Standard Laravel Breeze/Jetstream)
    // Ini memperbaiki error "Route [profile.edit] not defined"
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ==========================================
// 3. AUTH SYSTEM ROUTES
// ==========================================
// Memuat route login, register, logout bawaan Laravel
require __DIR__.'/auth.php';