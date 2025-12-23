<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;
use Livewire\WithPagination;

class SearchPage extends Component
{
    use WithPagination;

    // Kita gunakan variabel public biasa
    public $search = '';

    public function mount()
    {
        // Tangkap data dari URL saat pertama kali load
        $this->search = request()->query('q', '');
    }

    public function render()
    {
        // 1. Pastikan kita selalu membaca nilai terbaru dari URL
        // Ini mengatasi masalah jika Livewire mereset variabel
        $keyword = request()->query('q', $this->search);

        // 2. Query Database
        $books = Book::with('user')
            ->where(function($query) use ($keyword) {
                // Jika keyword kosong, jangan filter (tampilkan semua atau kosongkan logic ini)
                if (!empty($keyword)) {
                    $term = '%' . $keyword . '%';
                    $query->where('title', 'like', $term)
                          ->orWhere('synopsis', 'like', $term)
                          ->orWhereHas('user', function($q) use ($term) {
                              $q->where('name', 'like', $term);
                          });
                }
            })
            ->latest()
            ->paginate(12)
            ->withQueryString(); // <--- PENTING: Agar parameter ?q=... ikut ke halaman 2, 3, dst.

        return view('livewire.public.search-page', [
            'books'  => $books,
            'search' => $keyword, // Kirim keyword yang valid ke view
        ])->layout('layouts.public');
    }
}