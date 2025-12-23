<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class SearchPage extends Component
{
    use WithPagination;

    // Menangkap parameter ?q=... dari URL
    #[Url(as: 'q')] 
    public $search = '';

    /**
     * Tambahkan mount() untuk memastikan data tertangkap saat pertama load
     * Ini langkah antisipasi jika atribut #[Url] gagal di beberapa versi Livewire
     */
    public function mount()
    {
        $this->search = request()->query('q', $this->search);
    }

    public function render()
    {
        $books = Book::with('user')
            ->when($this->search, function($query) {
                // --- PERBAIKAN UTAMA DI SINI ---
                // Kita harus membungkus semua 'orWhere' dalam satu 'where(function($q){...})'
                // Ini setara dengan SQL: WHERE (title LIKE %..% OR synopsis LIKE %..%)
                // Tanpa ini, logika OR bisa "membocorkan" data (menampilkan semua buku).
                
                $query->where(function($q) {
                    $term = '%' . $this->search . '%';
                    
                    $q->where('title', 'like', $term)
                      ->orWhere('synopsis', 'like', $term)
                      ->orWhereHas('user', function($userQuery) use ($term) {
                          $userQuery->where('name', 'like', $term);
                      });
                });
            })
            ->latest()
            ->paginate(12); 

        return view('livewire.public.search-page', [
            'books'  => $books,
            'search' => $this->search,
        ])->layout('layouts.public');
    }
}