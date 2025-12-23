<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;
use Livewire\WithPagination;

class SearchPage extends Component
{
    use WithPagination;

    public function render()
    {
        // 1. Ambil keyword langsung dari URL (?q=...)
        $keyword = request()->query('q');

        // 2. Mulai Query Dasar
        $query = Book::with('user');

        // 3. Logika Filter
        if (!empty($keyword)) {
            // PENCARIAN STRICT: HANYA MENCARI DI JUDUL
            // Ini solusi agar hasil pencarian sangat akurat dan tidak "melebar" ke sinopsis.
            $query->where('title', 'like', '%' . $keyword . '%');
        }

        // 4. Eksekusi Data (Urutkan terbaru & Pagination)
        $books = $query->latest()
                       ->paginate(12)
                       ->withQueryString(); // Agar parameter ?q= tetap ikut saat pindah halaman

        return view('livewire.public.search-page', [
            'books'  => $books,
            'search' => $keyword,
        ])->layout('layouts.public');
    }
}