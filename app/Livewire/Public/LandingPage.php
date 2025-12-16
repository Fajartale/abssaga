<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;

class LandingPage extends Component
{
    public function render()
    {
        // 1. Ambil 2 buku acak untuk bagian "Pilihan Editor / Featured"
        // 'with('user')' digunakan untuk memuat nama penulis sekaligus (eager loading)
        $featuredBooks = Book::with('user')
                        ->inRandomOrder()
                        ->limit(2)
                        ->get();

        // 2. Ambil 8 buku yang paling baru dibuat
        $recentBooks = Book::with('user')
                        ->latest()
                        ->limit(8)
                        ->get();

        return view('livewire.public.landing-page', [
            'featuredBooks' => $featuredBooks,
            'recentBooks'   => $recentBooks
        ])->layout('layouts.public'); // Menggunakan layout public.blade.php
    }
}