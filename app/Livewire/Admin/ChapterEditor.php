<?php

// app/Livewire/Admin/ChapterEditor.php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Support\Str;

class ChapterEditor extends Component
{
    public $book;
    public $title;
    public $content;
    public $chapters;

    public function mount($bookId) {
        $this->book = Book::findOrFail($bookId);
        $this->loadChapters();
    }

    public function loadChapters() {
        $this->chapters = $this->book->chapters;
    }

    public function saveChapter() {
        $this->validate(['title' => 'required', 'content' => 'required']);

        Chapter::create([
            'book_id' => $this->book->id,
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'content' => $this->content, // Trix menyimpan HTML
            'order' => $this->book->chapters()->count() + 1
        ]);

        $this->reset(['title', 'content']);
        $this->loadChapters();
        // Dispatch event agar Trix editor kosong kembali (perlu JS tambahan)
    }

    public function render() {
        return view('livewire.admin.chapter-editor')
        ->layout('layouts.public'); 
    }
}