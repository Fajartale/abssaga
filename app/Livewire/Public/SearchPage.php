<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;
use Livewire\WithPagination;

class SearchPage extends Component
{
    use WithPagination;

    // Kita abaikan properti public $search untuk query database
    // karena kita akan mengambil langsung dari Request URL
    
    public function render()
    {
        // 1. Ambil keyword langsung dari URL (?q=...)
        // Jika tidak ada ?q=, maka nilainya null
        $keyword = request()->query('q');

        // 2. Query menggunakan Scope yang baru kita buat
        $books = Book::with('user')
            // Jika $keyword ada isinya, jalankan scopeSearch
            ->when($keyword, function($query) use ($keyword) {
                return $query->search($keyword);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString(); // Agar pagination halaman 2 tetap membawa ?q=...

        return view('livewire.public.search-page', [
            'books'  => $books,
            'search' => $keyword, // Kirim keyword untuk ditampilkan di view
        ])->layout('layouts.public');
    }
}