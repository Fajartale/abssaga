<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class SearchPage extends Component
{
    use WithPagination;

    #[Url(as: 'q')] 
    public $search = '';

    public function render()
    {
        $books = Book::with('user')
            ->when($this->search, function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('synopsis', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->latest()
            ->paginate(12); 

        return view('livewire.public.search-page', [
            'books'  => $books,
            'search' => $this->search, // <--- PERBAIKAN: Kirim variabel search ke view
        ])->layout('layouts.public');
    }
}