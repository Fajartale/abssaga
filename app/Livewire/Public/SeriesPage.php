<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;
use Livewire\WithPagination;

class SeriesPage extends Component
{
    use WithPagination;

    public $genre = 'All'; // Default filter

    // Daftar Genre (Bisa diganti dinamis dari database jika ada tabel genres)
    public $genres = ['All', 'Action', 'Romance', 'Fantasy', 'Horror', 'System', 'Comedy', 'Slice of Life'];

    public function setGenre($genre)
    {
        $this->genre = $genre;
        $this->resetPage(); // Reset ke halaman 1 saat ganti filter
    }

    public function render()
    {
        $query = Book::with('user')->latest();

        // Logika Filter Sederhana (Asumsi genre disimpan di kolom synopsis atau title untuk sementara)
        // Jika Anda punya kolom 'genre' di database, ganti 'synopsis' menjadi 'genre'
        if ($this->genre !== 'All') {
            $query->where('synopsis', 'like', '%' . $this->genre . '%')
                  ->orWhere('title', 'like', '%' . $this->genre . '%');
        }

        return view('livewire.public.series-page', [
            'books' => $query->paginate(12)
        ])->layout('layouts.public');
    }
}