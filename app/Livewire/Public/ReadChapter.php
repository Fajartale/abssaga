<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Chapter;
use App\Models\Book;

class ReadChapter extends Component
{
    public $chapter;
    public $book;
    public $nextChapter;
    public $prevChapter;

    public function mount($id)
    {
        // 1. Ambil data chapter saat ini
        $this->chapter = Chapter::with('book')->findOrFail($id);
        $this->book = $this->chapter->book;

        // 2. Cari Chapter Selanjutnya (Next)
        // Cari chapter dengan 'order' lebih besar dari chapter ini, di buku yang sama
        $this->nextChapter = Chapter::where('book_id', $this->book->id)
            ->where('order', '>', $this->chapter->order)
            ->orderBy('order', 'asc')
            ->first();

        // 3. Cari Chapter Sebelumnya (Prev)
        // Cari chapter dengan 'order' lebih kecil dari chapter ini
        $this->prevChapter = Chapter::where('book_id', $this->book->id)
            ->where('order', '<', $this->chapter->order)
            ->orderBy('order', 'desc')
            ->first();
    }

    public function render()
    {
        return view('livewire.public.read-chapter')
            ->layout('layouts.public'); 
    }
}