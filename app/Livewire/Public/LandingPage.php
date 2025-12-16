<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;

class LandingPage extends Component
{
    public function render()
    {
        // Mengambil 2 buku secara acak sebagai simulasi "Favorit/Featured"
        $featuredBooks = Book::with('user')
                        ->inRandomOrder()
                        ->limit(2)
                        ->get();

        // Mengambil 8 buku terbaru
        $recentBooks = Book::with('user')
                        ->latest()
                        ->limit(8)
                        ->get();

        return view('livewire.public.landing-page', [
            'featuredBooks' => $featuredBooks,
            'recentBooks' => $recentBooks
        ])->layout('layouts.public');
    }
}