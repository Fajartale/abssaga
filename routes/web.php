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
// Pastikan namespace sesuai dengan folder: App\Livewire\Admin
use App\Livewire\Admin\ManageBooks; 
use App\Livewire\Admin\ChapterEditor;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', LandingPage::class)->name('home');
// ... (Route public lainnya tetap sama) ...

// ==========================================
// 2. AUTHENTICATED ROUTES (Harus Login)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // 1. Route untuk Tambah/Edit Buku (Data Umum: Judul, Sinopsis, Cover)
    // Parameter {id?} bersifat opsional. Jika kosong = Buat Baru.
    Route::get('/book/manage/{id?}', ManageBooks::class)->name('book.manage');

    // 2. Route untuk Edit Chapter (Bab)
    // Parameter {bookId} wajib agar kita tahu chapter ini milik buku siapa.
    Route::get('/book/{bookId}/chapters', ChapterEditor::class)->name('book.chapters');

    // ... (Route Profile tetap sama) ...
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';