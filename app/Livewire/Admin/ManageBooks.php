<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads; // Wajib untuk upload file
use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ManageBooks extends Component
{
    use WithFileUploads;

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
        // Mengambil buku milik user yang sedang login, urutkan dari yang terbaru
        $this->books = Book::where('user_id', Auth::id())->latest()->get();
    }

    public function save()
    {
        // 1. Validasi Input
        $this->validate([
            'title' => 'required|min:3',
            'synopsis' => 'required|min:10',
            'cover' => 'nullable|image|max:2048', // Maksimal 2MB, boleh kosong
        ], [
            'title.required' => 'Judul buku wajib diisi!',
            'synopsis.required' => 'Sinopsis wajib diisi!',
            'cover.image' => 'File harus berupa gambar.',
        ]);

        // 2. Proses Upload Gambar (Jika ada)
        $path = null;
        if ($this->cover) {
            $path = $this->cover->store('covers', 'public');
        }

        // 3. Simpan ke Database
        Book::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            // Membuat slug unik dengan menambahkan string acak agar tidak bentrok
            'slug' => Str::slug($this->title) . '-' . Str::random(5),
            'synopsis' => $this->synopsis,
            'cover_image' => $path
        ]);

        // 4. Reset Form & Reload Data
        $this->reset(['title', 'synopsis', 'cover']);
        $this->loadBooks();
        
        // 5. Kirim pesan sukses (Flash Message)
        session()->flash('message', 'Buku berhasil diterbitkan! Silakan tambah chapter.');
    }

    public function render()
    {
        // PENTING: Menggunakan layout 'layouts.app' agar navigasi muncul
        return view('livewire.admin.manage-books')
            ->layout('layouts.app');
    }
}