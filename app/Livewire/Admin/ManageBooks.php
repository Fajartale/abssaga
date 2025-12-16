<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads; // PENTING: Untuk upload gambar
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
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $this->loadBooks();
    }

    public function loadBooks() {
        $this->books = Book::where('user_id', Auth::id())->latest()->get();
    }

    public function save() {
        // 1. VALIDASI (Penting agar data sesuai aturan database)
        $this->validate([
            'title' => 'required|min:3|max:255',
            'synopsis' => 'required|min:10',
            'cover' => 'nullable|image|max:2048', // Maksimal 2MB (2048 KB)
        ], [
            'title.required' => 'Judul buku wajib diisi!',
            'synopsis.required' => 'Sinopsis minimal 10 karakter.',
            'cover.max' => 'Ukuran gambar terlalu besar! Maksimal 2MB.',
            'cover.image' => 'File harus berupa gambar (JPG, PNG).',
        ]);

        // 2. PROSES UPLOAD
        $path = null;
        if ($this->cover) {
            $path = $this->cover->store('covers', 'public');
        }

        // 3. GENERATE SLUG UNIK (Agar tidak error saat judul sama)
        // Menambahkan 4 karakter acak di belakang slug
        $slug = Str::slug($this->title) . '-' . Str::random(4);

        // 4. SIMPAN KE DATABASE
        Book::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'slug' => $slug,
            'synopsis' => $this->synopsis,
            'cover_image' => $path
        ]);

        // 5. RESET FORM
        $this->reset(['title', 'synopsis', 'cover']);
        
        // 6. RELOAD DATA & BERI KABAR
        $this->loadBooks();
        session()->flash('message', 'Buku BERHASIL disimpan ke database!');
    }

    public function render() {
        // Menggunakan layout admin
        return view('livewire.admin.manage-books')
            ->layout('layouts.app');
    }
}