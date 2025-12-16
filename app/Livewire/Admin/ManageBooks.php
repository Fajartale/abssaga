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

    public $title;
    public $synopsis;
    public $cover;
    public $books;

    public function mount() {
        $this->loadBooks();
    }

    public function loadBooks() {
        // Ambil buku user, urutkan dari terbaru
        $this->books = Book::where('user_id', Auth::id())->latest()->get();
    }

    public function save() {
        // 1. Validasi Input
        $this->validate([
            'title' => 'required|min:3',
            'synopsis' => 'required',
            'cover' => 'nullable|image|max:2048', // Max 2MB
        ], [
            // Custom pesan error
            'title.required' => 'Judul buku wajib diisi.',
            'synopsis.required' => 'Sinopsis wajib diisi.',
            'cover.max' => 'Ukuran gambar maksimal 2MB.',
            'cover.image' => 'File harus berupa gambar.'
        ]);

        // 2. Upload Gambar (Jika ada)
        $path = null;
        if ($this->cover) {
            $path = $this->cover->store('covers', 'public');
        }

        // 3. Simpan ke Database
        Book::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            // PENTING: Tambah random string agar slug unik dan tidak error database
            'slug' => Str::slug($this->title) . '-' . Str::random(5),
            'synopsis' => $this->synopsis,
            'cover_image' => $path
        ]);

        // 4. Reset Form
        $this->reset(['title', 'synopsis', 'cover']);
        
        // 5. Reload Data & Kirim Notifikasi
        $this->loadBooks();
        session()->flash('message', 'Buku berhasil diterbitkan!');
    }

    public function render() {
        // PENTING: Pastikan layout dipanggil agar style & script jalan
        return view('livewire.admin.manage-books')
            ->layout('layouts.app');
    }
}