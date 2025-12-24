<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;

class RankingPage extends Component
{
    public function render()
    {
        // Mengambil 50 buku teratas berdasarkan jumlah chapter
        // Jika nanti ada kolom 'views', ganti 'chapters_count' dengan 'views'
        $books = Book::with('user')
            ->withCount('chapters')
            ->orderByDesc('chapters_count')
            ->limit(50)
            ->get();

        return view('livewire.public.ranking-page', [
            'books' => $books
        ])->layout('layouts.public');
    }
}