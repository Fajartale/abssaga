<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ManageBooks extends Component
{
    use WithFileUploads;

    public $title, $synopsis, $cover, $books;

    public function mount() {
        $this->loadBooks();
    }

    public function loadBooks() {
        $this->books = Book::where('user_id', Auth::id())->get();
    }

    public function save() {
        $this->validate([
            'title' => 'required',
            'synopsis' => 'required',
            'cover' => 'image|max:1024', // 1MB Max
        ]);

        $path = $this->cover ? $this->cover->store('covers', 'public') : null;

        Book::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'synopsis' => $this->synopsis,
            'cover_image' => $path
        ]);

        $this->reset(['title', 'synopsis', 'cover']);
        $this->loadBooks();
    }

    public function render() {
        // PERBAIKAN DI SINI: Tambahkan ->layout('layouts.app')
        return view('livewire.admin.manage-books')
            ->layout('layouts.public'); 
    }
}