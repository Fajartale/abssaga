<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookDetail extends Component
{
    public $book;

    /**
     * Mount berjalan saat halaman pertama kali dimuat.
     * Menerima parameter $id dari URL (Route).
     */
    public function mount($id)
    {
        try {
            // Ambil buku berdasarkan ID
            $this->book = Book::with([
                'user', // Ambil data penulis
                'chapters' => function ($query) {
                    $query->orderBy('order', 'asc'); // Urutkan chapter dari yang paling awal (order 1)
                }
            ])->findOrFail($id);

        } catch (ModelNotFoundException $e) {
            // Jika buku tidak ditemukan (misal ID ngawur), arahkan ke 404 atau Home
            abort(404); 
        }
    }

    public function render()
    {
        // Logika untuk tombol "MULAI BACA BAB 1"
        // Kita ambil chapter pertama dari koleksi chapters yang sudah diurutkan di mount()
        $firstChapter = $this->book->chapters->first();

        return view('livewire.public.book-detail', [
            'firstChapter' => $firstChapter
        ])->layout('layouts.public'); // Pastikan menggunakan layout public yang sama dengan Landing Page
    }
}