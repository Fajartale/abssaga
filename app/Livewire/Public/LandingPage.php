<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Book;
use Livewire\Attributes\Layout;

class LandingPage extends Component
{
    public $search = '';

    #[Layout('layouts.public')] 
    public function render()
    {
        // Ambil 5 buku acak untuk slider (Featured)
        $featuredBooks = Book::inRandomOrder()->limit(5)->get();

        // Ambil data buku untuk Ranking (misalnya berdasarkan ID atau View jika ada)
        $rankedBooks = Book::orderBy('id', 'asc')->limit(10)->get();

        // Query Utama dengan Search
        $books = Book::query()
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(12);

        return view('livewire.public.landing-page', [
            'featuredBooks' => $featuredBooks,
            'rankedBooks' => $rankedBooks,
            'books' => $books
        ]);
    }
}