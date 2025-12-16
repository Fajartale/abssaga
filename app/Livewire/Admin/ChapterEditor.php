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

    // State management
    public $isEditing = false;
    public $editingId = null;

    public function mount($bookId) {
        $this->book = Book::findOrFail($bookId);
        $this->loadChapters();
    }

    public function loadChapters() {
        // Load chapter urut berdasarkan 'order'
        $this->chapters = $this->book->chapters()->orderBy('order', 'asc')->get();
    }

    // --- FITUR SIMPAN BARU ---
    public function saveChapter() {
        $this->validate(['title' => 'required', 'content' => 'required']);

        Chapter::create([
            'book_id' => $this->book->id,
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'content' => $this->content,
            'order' => $this->book->chapters()->count() + 1
        ]);

        $this->resetForm();
        $this->dispatch('trix-clear'); // Event untuk kosongkan editor
    }

    // --- FITUR EDIT ---
    public function edit($id) {
        $chapter = Chapter::findOrFail($id);
        
        $this->isEditing = true;
        $this->editingId = $chapter->id;
        $this->title = $chapter->title;
        $this->content = $chapter->content;

        // Dispatch event agar Trix Editor memuat isi chapter
        $this->dispatch('trix-load-content', content: $this->content);
    }

    public function update() {
        $this->validate(['title' => 'required', 'content' => 'required']);

        $chapter = Chapter::findOrFail($this->editingId);
        $chapter->update([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'content' => $this->content,
        ]);

        $this->resetForm();
        $this->dispatch('trix-clear');
    }

    public function cancel() {
        $this->resetForm();
        $this->dispatch('trix-clear');
    }

    // --- FITUR URUTAN (REORDER) ---
    public function move($id, $direction) {
        $chapter = Chapter::findOrFail($id);
        
        // Cari chapter tetangga berdasarkan arah
        $operator = $direction === 'up' ? '<' : '>';
        $orderDirection = $direction === 'up' ? 'desc' : 'asc';

        $neighbor = $this->book->chapters()
                    ->where('order', $operator, $chapter->order)
                    ->orderBy('order', $orderDirection)
                    ->first();

        if ($neighbor) {
            // Tukar posisi order
            $tempOrder = $chapter->order;
            $chapter->update(['order' => $neighbor->order]);
            $neighbor->update(['order' => $tempOrder]);
            
            $this->loadChapters();
        }
    }

    private function resetForm() {
        $this->reset(['title', 'content', 'isEditing', 'editingId']);
        $this->loadChapters();
    }

    public function render() {
        return view('livewire.admin.chapter-editor')
        ->layout('layouts.public'); 
    }
}