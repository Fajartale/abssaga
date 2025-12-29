<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController; 

// --- IMPORT LIVEWIRE COMPONENTS ---

// 1. Public Components
use App\Livewire\Public\LandingPage;
use App\Livewire\Public\SearchPage;
use App\Livewire\Public\SeriesPage;
use App\Livewire\Public\RankingPage;
use App\Livewire\Public\BookDetail;
use App\Livewire\Public\ReadChapter;

// 2. Auth/Author Components
use App\Livewire\Dashboard;
use App\Livewire\ManageBook; // <--- SAYA TAMBAHKAN INI

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. PUBLIC ROUTES (Dapat diakses Tamu)
// ==========================================

Route::get('/', LandingPage::class)->name('home');
Route::get('/search', SearchPage::class)->name('search');
Route::get('/series', SeriesPage::class)->name('series');
Route::get('/ranking', RankingPage::class)->name('ranking');
Route::get('/book/{id}', BookDetail::class)->name('book.detail');
Route::get('/chapter/{id}', ReadChapter::class)->name('chapter.read');


// ==========================================
// 2. AUTHENTICATED ROUTES (Harus Login)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Penulis
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // --- SAYA TAMBAHKAN ROUTE INI (MANAGE BOOK) ---
    // Perhatikan: TIDAK ADA tanda kurung siku [] di sekitar ManageBook::class
    // Route::get('/book/manage/{id?}', ManageBook::class)->name('book.manage');

    // --- PROFILE ROUTES (Script Lama Anda) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ==========================================
// 3. AUTH SYSTEM ROUTES
// ==========================================
require __DIR__.'/auth.php';