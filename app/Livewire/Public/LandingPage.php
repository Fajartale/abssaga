<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;
use Livewire\WithPagination;

class LandingPage extends Component
{
    use WithPagination;

    // Properti untuk pencarian (wire:model="search")
    public $search = '';

    // Reset halaman pagination saat search berubah
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // 1. FEATURED BOOKS (Slider)
        // Mengambil 5 buku acak untuk slider
        $featuredBooks = Book::with('user')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        // 2. RANKED BOOKS (Sidebar)
        // Contoh logika: Buku dengan jumlah chapter terbanyak
        $rankedBooks = Book::withCount('chapters')
            ->orderBy('chapters_count', 'desc')
            ->limit(5)
            ->get();

        // 3. RECENT BOOKS (Main Grid)
        // Mengambil buku terbaru dengan fitur pencarian
        $recentBooks = Book::with('user')
            ->withCount('chapters') // Untuk menampilkan jumlah chapter di card
            ->when($this->search, function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('synopsis', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(8); // Menggunakan pagination (8 buku per halaman)

        return view('livewire.public.landing-page', [
            'featuredBooks' => $featuredBooks,
            'rankedBooks'   => $rankedBooks,
            'recentBooks'   => $recentBooks // <-- Variabel ini yang dicari oleh View
        ])->layout('layouts.public');
    }
}