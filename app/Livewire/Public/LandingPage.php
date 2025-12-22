<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;
use Livewire\WithPagination; // Tambahkan ini untuk pagination halaman baru

class LandingPage extends Component
{
    use WithPagination; // Aktifkan pagination

    public function render()
    {
        // 1. FEATURED BOOKS (Untuk Slider)
        // Ambil 5 buku acak
        $featuredBooks = Book::with('user')
                        ->inRandomOrder()
                        ->limit(5)
                        ->get();

        // 2. RANKED BOOKS (Untuk Sidebar Kanan)
        // Ranking berdasarkan jumlah chapter terbanyak
        $rankedBooks = Book::withCount('chapters')
                        ->orderBy('chapters_count', 'desc')
                        ->limit(5)
                        ->get();

        // 3. RECENT BOOKS (Untuk Grid Utama)
        // Menggunakan paginate() agar halaman tidak berat
        $recentBooks = Book::with('user')
                        ->latest()
                        ->paginate(8); 

        return view('livewire.public.landing-page', [
            'featuredBooks' => $featuredBooks,
            'rankedBooks'   => $rankedBooks,
            'recentBooks'   => $recentBooks
        ])->layout('layouts.public');
    }
}