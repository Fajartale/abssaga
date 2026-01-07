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
use App\Livewire\Admin\ManageBooks;  // [Perbaikan] Gunakan namespace Admin & nama jamak
use App\Livewire\Admin\ChapterEditor; // [Tambahan] Untuk edit chapter

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. PUBLIC ROUTES (Bisa diakses siapa saja)
// ==========================================
Route::get('/', LandingPage::class)->name('home');
Route::get('/search', SearchPage::class)->name('search');
Route::get('/series', SeriesPage::class)->name('series');
Route::get('/ranking', RankingPage::class)->name('ranking');

// Route Detail Buku & Baca Chapter
Route::get('/book/{id}', BookDetail::class)->name('book.detail');
Route::get('/chapter/{id}', ReadChapter::class)->name('chapter.read');


// ==========================================
// 2. AUTHENTICATED ROUTES (Harus Login)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // [Perbaikan] Route Manage Books (Create/Edit)
    Route::get('/book/manage/{id?}', ManageBooks::class)->name('book.manage');

    // [Tambahan] Route Manage Chapters (Isi Buku)
    Route::get('/book/{bookId}/chapters', ChapterEditor::class)->name('book.chapters');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';