<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads; // WAJIB: Agar bisa upload gambar
use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ManageBooks extends Component
{
    use WithFileUploads; // WAJIB: Trait dipasang di sini

    public $title;
    public $synopsis;
    public $cover;
    public $books;

    public function mount()
    {
        $this->loadBooks();
    }

    public function loadBooks()
    {
        // Ambil buku milik user yang login
        $this->books = Book::where('user_id', Auth::id())->latest()->get();
    }

    public function save()
    {
        // 1. Validasi
        $this->validate([
            'title' => 'required|min:3|max:255',
            'synopsis' => 'required|min:10',
            'cover' => 'nullable|image|max:2048', // Max 2MB
        ], [
            'title.required' => 'Judul tidak boleh kosong.',
            'cover.image' => 'File harus berupa gambar.',
            'cover.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // 2. Upload Gambar
        $path = null;
        if ($this->cover) {
            // Simpan ke folder 'public/covers'
            $path = $this->cover->store('covers', 'public');
        }

        // 3. Simpan Database
        Book::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            // Tambah random string agar slug unik
            'slug' => Str::slug($this->title) . '-' . Str::random(5),
            'synopsis' => $this->synopsis,
            'cover_image' => $path
        ]);

        // 4. Reset & Reload
        $this->reset(['title', 'synopsis', 'cover']);
        $this->loadBooks();
        
        session()->flash('message', 'Buku berhasil diterbitkan! Silakan tambah chapter.');
    }

    public function deleteBook($id)
    {
        $book = Book::where('user_id', Auth::id())->find($id);
        
        if ($book) {
            // Hapus gambar cover jika ada
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $book->delete();
            $this->loadBooks();
        }
    }

    public function render()
    {
        // Pastikan menggunakan layout admin (layouts.app)
        return view('livewire.admin.manage-books')
            ->layout('layouts.app');
    }
}