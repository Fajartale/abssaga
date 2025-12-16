<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Import Livewire Components
use App\Livewire\Public\LandingPage;
use App\Livewire\Public\BookDetail;
use App\Livewire\Public\ReadChapter;
use App\Livewire\Admin\ManageBooks;
use App\Livewire\Admin\ChapterEditor;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ====================================================
// 1. PUBLIC ROUTES (Bisa diakses Tanpa Login)
// ====================================================

// Halaman Depan (Landing Page)
Route::get('/', LandingPage::class)->name('home');

// Halaman Detail Buku
Route::get('/book/{id}', BookDetail::class)->name('book.show');

// Halaman Baca Chapter
Route::get('/read/{id}', ReadChapter::class)->name('chapter.read');


// ====================================================
// 2. AUTHOR / ADMIN ROUTES (Wajib Login)
// ====================================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Utama (List Buku & Form Tambah Buku)
    Route::get('/dashboard', ManageBooks::class)->name('dashboard');

    // Halaman Editor Menulis (Trix Editor)
    Route::get('/write/{bookId}', ChapterEditor::class)->name('admin.chapters');
});


// ====================================================
// 3. PROFILE ROUTES (Bawaan Laravel Breeze)
// ====================================================
// Bagian ini PENTING agar error "Route [profile.edit] not defined" hilang
// karena layout navigasi default memanggil route ini.

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ====================================================
// 4. AUTH ROUTES (Login, Register, Logout)
// ====================================================
require __DIR__.'/auth.php';