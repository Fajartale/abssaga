<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;
use Livewire\WithPagination;

class SearchPage extends Component
{
    use WithPagination;

    // Variabel ini untuk binding data ke View (opsional, tapi bagus untuk sinkronisasi)
    public $search = '';

    /**
     * MOUNT: Berjalan sekali saat halaman dimuat.
     * Mengambil parameter ?q=... dari URL dan memasukkannya ke variabel $search.
     */
    public function mount()
    {
        $this->search = request()->query('q', '');
    }

    /**
     * RENDER: Berjalan setiap kali ada update atau refresh.
     */
    public function render()
    {
        // 1. Sumber Kebenaran (Source of Truth) adalah URL
        // Kita paksa ambil dari request('q') agar pencarian tidak hilang saat ganti halaman pagination
        $keyword = request()->query('q');

        // 2. Query Database
        $books = Book::with('user')
            // Cek jika ada keyword
            ->when($keyword, function($query) use ($keyword) {
                // Panggil Scope 'search' yang sudah kita buat di Model Book.php
                // Ini menjamin logika OR terbungkus rapi: WHERE (title... OR synopsis...)
                return $query->search($keyword);
            })
            ->latest() // Urutkan dari yang terbaru
            ->paginate(12) // Batasi 12 buku per halaman
            ->withQueryString(); // PENTING: Agar parameter ?q=... ikut terbawa ke link halaman 2, 3, dst.

        // 3. Kirim data ke View
        return view('livewire.public.search-page', [
            'books'  => $books,
            'search' => $keyword, // Kirim keyword agar input text tetap terisi
        ])->layout('layouts.public');
    }
}