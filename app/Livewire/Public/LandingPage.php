<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;
use Livewire\WithPagination;

class LandingPage extends Component
{
    use WithPagination;

    // Properti untuk menangkap input pencarian dari View
    public $search = '';

    // Reset halaman ke 1 setiap kali user mengetik di search bar
    // Agar hasil pencarian tidak error jika jumlah halaman berubah
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // 1. FEATURED BOOKS (Untuk Slider Atas)
        // Mengambil 5 buku secara acak beserta data user (penulis)
        $featuredBooks = Book::with('user')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        // 2. RANKED BOOKS (Untuk Sidebar Kanan)
        // Mengurutkan buku berdasarkan jumlah chapter terbanyak
        // withCount('chapters') akan menambahkan atribut 'chapters_count' pada setiap object buku
        $rankedBooks = Book::withCount('chapters')
            ->orderBy('chapters_count', 'desc')
            ->limit(5)
            ->get();

        // 3. RECENT BOOKS (Untuk Grid Utama & Pencarian)
        // Query dasar mengambil buku terbaru
        $recentBooks = Book::with('user')
            ->when($this->search, function($query) {
                // Jika ada input search, filter berdasarkan judul atau sinopsis
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('synopsis', 'like', '%' . $this->search . '%');
            })
            ->latest() // Urutkan dari yang paling baru dibuat
            ->paginate(8); // Batasi 8 buku per halaman

        // Kirim semua variabel ke View
        return view('livewire.public.landing-page', [
            'featuredBooks' => $featuredBooks,
            'rankedBooks'   => $rankedBooks,
            'recentBooks'   => $recentBooks
        ])->layout('layouts.public'); 
        // Pastikan layout menggunakan 'layouts.public' sesuai struktur project Anda
    }
}