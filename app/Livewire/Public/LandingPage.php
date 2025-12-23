<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;
use Livewire\WithPagination; // Wajib import ini untuk pagination

class LandingPage extends Component
{
    use WithPagination; // Gunakan trait pagination

    // 1. Properti Search
    // Variabel ini otomatis terhubung dengan input 'wire:model="search"' di Blade
    public $search = '';

    // 2. Reset Halaman
    // Setiap kali user mengetik di search bar, reset halaman ke 1 agar tidak error
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // A. FEATURED BOOKS (Slider Atas)
        // Tetap ambil 5 buku acak untuk slider
        $featuredBooks = Book::with('user')
                        ->inRandomOrder()
                        ->limit(5)
                        ->get();

        // B. RANKED BOOKS (Sidebar Kanan)
        // Ambil 5 buku dengan jumlah chapter terbanyak
        $rankedBooks = Book::withCount('chapters')
                        ->orderBy('chapters_count', 'desc')
                        ->limit(5)
                        ->get();

        // C. RECENT BOOKS (Main Grid & Search Logic)
        $recentBooks = Book::with('user')
            // Logika Pencarian
            ->when($this->search, function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('synopsis', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function($q) { // Opsional: Cari berdasarkan nama penulis
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->latest() // Urutkan dari yang terbaru
            ->paginate(8); // Batasi 8 buku per halaman (gunakan link() di view untuk navigasi)

        return view('livewire.public.landing-page', [
            'featuredBooks' => $featuredBooks,
            'rankedBooks'   => $rankedBooks,
            'recentBooks'   => $recentBooks
        ])->layout('layouts.public');
    }
}