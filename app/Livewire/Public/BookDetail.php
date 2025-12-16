<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;

class BookDetail extends Component
{
    public $book;

    public function mount($id)
    {
        // Mengambil data buku berdasarkan ID
        // Menggunakan 'with' untuk Eager Loading agar hemat query database
        $this->book = Book::with(['user', 'chapters' => function($query) {
            $query->orderBy('order', 'asc'); // Urutkan chapter dari bab 1
        }])->findOrFail($id);
    }

    public function render()
    {
        // Mengambil chapter pertama untuk tombol "Mulai Baca"
        $firstChapter = $this->book->chapters->first();

        return view('livewire.public.book-detail', [
            'firstChapter' => $firstChapter
        ])->layout('layouts.public'); // Pastikan layout utama kamu bernama 'app'
    }
}