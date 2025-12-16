<?php

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
        $this->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        Chapter::create([
            'book_id' => $this->book->id,
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'content' => $this->content, 
            'order' => $this->book->chapters()->count() + 1
        ]);

        // Reset variable form
        $this->reset(['title', 'content']);
        
        // Reload daftar chapter
        $this->loadChapters();
        
        // KIRIM EVENT KE BROWSER UNTUK MEMBERSIHKAN TRIX EDITOR
        $this->dispatch('chapter-created'); 
    }

    public function render() {
        return view('livewire.admin.chapter-editor')
        ->layout('layouts.public'); 
    }
}