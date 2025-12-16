<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Import Livewire Components
// Pastikan namespace ini sesuai dengan lokasi file Livewire kamu
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
// Menampilkan daftar semua buku
Route::get('/', LandingPage::class)->name('home');

// Halaman Detail Buku
// Menampilkan sinopsis dan daftar chapter
Route::get('/book/{id}', BookDetail::class)->name('book.show');

// Halaman Baca Chapter
// Menampilkan isi cerita per bab
Route::get('/read/{id}', ReadChapter::class)->name('chapter.read');


// ====================================================
// 2. AUTHOR / ADMIN ROUTES (Wajib Login)
// ====================================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Utama 
    // Tempat upload buku baru & kelola buku yang ada
    Route::get('/dashboard', ManageBooks::class)->name('dashboard');

    // Halaman Editor Menulis
    // Tempat menulis chapter baru untuk buku tertentu
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
// Memuat route bawaan Breeze (login, register, forgot-password, dll)
require __DIR__.'/auth.php';