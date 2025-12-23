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
        // 1. Ambil keyword dari URL
        $keyword = request()->query('q');

        // 2. Mulai Query
        $query = Book::with('user');

        // 3. Logic Filter Langsung (Tanpa Scope Model)
        // Kita gunakan IF manual agar kita yakin 100% filter ini dijalankan
        if (!empty($keyword)) {
            $query->where(function($q) use ($keyword) {
                $term = '%' . $keyword . '%';
                
                $q->where('title', 'like', $term)
                  ->orWhere('synopsis', 'like', $term)
                  ->orWhereHas('user', function($userQuery) use ($term) {
                      $userQuery->where('name', 'like', $term);
                  });
            });
        }

        // 4. Eksekusi Pagination
        $books = $query->latest()
                       ->paginate(12)
                       ->withQueryString();

        return view('livewire.public.search-page', [
            'books'  => $books,
            'search' => $keyword, 
        ])->layout('layouts.public');
    }
}