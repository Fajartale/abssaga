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

// --- 2. IMPORT LIVEWIRE ADMIN/AUTH COMPONENTS ---
use App\Livewire\Dashboard;
use App\Livewire\Admin\ManageBooks;   // [PERBAIKAN] Menggunakan namespace Admin & nama jamak
use App\Livewire\Admin\ChapterEditor; // [TAMBAHAN] Import ini wajib untuk fitur edit chapter

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. PUBLIC ROUTES (Dapat diakses Siapa Saja)
// ==========================================

Route::get('/', LandingPage::class)->name('home');
Route::get('/search', SearchPage::class)->name('search');
Route::get('/series', SeriesPage::class)->name('series');
Route::get('/ranking', RankingPage::class)->name('ranking');

// Route Detail & Baca
Route::get('/book/{id}', BookDetail::class)->name('book.detail');
Route::get('/chapter/{id}', ReadChapter::class)->name('chapter.read');


// ==========================================
// 2. AUTHENTICATED ROUTES (Harus Login)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Penulis
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // [PERBAIKAN] Route Manage Books (Create/Edit)
    // Parameter {id?} opsional: Jika kosong = Create, Jika ada = Edit
    Route::get('/book/manage/{id?}', ManageBooks::class)->name('book.manage');

    // [TAMBAHAN] Route Manage Chapters (Kelola Isi Buku)
    // Wajib ada agar tombol "Kelola Daftar Chapter" berfungsi
    Route::get('/book/{bookId}/chapters', ChapterEditor::class)->name('book.chapters');

    // --- PROFILE ROUTES ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ==========================================
// 3. AUTH SYSTEM ROUTES
// ==========================================
require __DIR__.'/auth.php';