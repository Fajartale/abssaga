<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class SearchPage extends Component
{
    use WithPagination;

    // Sinkronisasi URL ?q=... dengan variabel $search
    // history: true agar URL berubah saat user mengetik
    #[Url(as: 'q', history: true)] 
    public $search = '';

    /**
     * Mount: Memaksa variabel $search terisi dari URL saat halaman pertama kali dibuka.
     * Ini adalah backup jika atribut #[Url] tidak langsung bekerja.
     */
    public function mount()
    {
        $this->search = request()->query('q', '');
    }

    /**
     * Reset pagination ke halaman 1 setiap kali search berubah
     */
    public function updatedSearch() 
    {
        $this->resetPage();
    }

    public function render()
    {
        // 1. Mulai Query Dasar
        $query = Book::with('user')->latest();

        // 2. Cek apakah ada pencarian
        if (!empty($this->search)) {
            // Jika ada search, tambahkan filter dengan kurung pengelompokan (where group)
            $query->where(function($q) {
                $term = '%' . $this->search . '%';
                
                $q->where('title', 'like', $term)
                  ->orWhere('synopsis', 'like', $term)
                  ->orWhereHas('user', function($userQ) use ($term) {
                      $userQ->where('name', 'like', $term);
                  });
            });
        }

        // 3. Eksekusi Pagination
        $books = $query->paginate(12);

        return view('livewire.public.search-page', [
            'books'  => $books,
            'search' => $this->search, // Pastikan variabel ini dikirim ke View
        ])->layout('layouts.public');
    }
}