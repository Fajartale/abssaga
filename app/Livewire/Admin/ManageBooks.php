<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads; // Wajib untuk upload file
use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ManageBooks extends Component
{
    use WithFileUploads;

    public $title;
    public $synopsis;
    public $cover; // Property untuk file sementara
    public $books;

    public function mount() {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $this->loadBooks();
    }

    public function loadBooks() {
        // Ambil buku milik user yang login, urutkan dari yang terbaru
        $this->books = Book::where('user_id', Auth::id())->latest()->get();
    }

    public function save() {
        // 1. VALIDASI
        // Perbaikan: Limit dinaikkan ke 5MB (5120KB) atau 10MB (10240KB) sesuai kebutuhan.
        // Catatan: Pastikan 'upload_max_filesize' & 'post_max_size' di php.ini server > dari nilai ini.
        $this->validate([
            'title' => 'required|min:3|max:255',
            'synopsis' => 'required|min:10',
            'cover' => 'nullable|image|max:10240', // Maksimal 10MB
        ], [
            'title.required' => 'Judul buku wajib diisi!',
            'synopsis.required' => 'Sinopsis minimal 10 karakter.',
            'cover.image' => 'File harus berupa gambar (JPG, PNG, JPEG).',
            'cover.max' => 'Ukuran gambar terlalu besar! Maksimal 10MB.',
        ]);

        // 2. PROSES UPLOAD GAMBAR
        $coverPath = null;
        
        // Cek apakah ada file cover yang diupload
        if ($this->cover) {
            // Simpan ke folder 'covers' di disk 'public'
            // Hasilnya misal: covers/namafileacak.jpg
            $coverPath = $this->cover->store('covers', 'public');
        }

        // 3. GENERATE SLUG
        $slug = Str::slug($this->title) . '-' . Str::random(4);

        // 4. SIMPAN KE DATABASE
        Book::create([
            'user_id'     => Auth::id(),
            'title'       => $this->title,
            'slug'        => $slug,
            'synopsis'    => $this->synopsis,
            'cover_image' => $coverPath, // Simpan path gambar atau null
        ]);

        // 5. BERSIHKAN FORM
        $this->reset(['title', 'synopsis', 'cover']);
        
        // 6. UPDATE TAMPILAN
        $this->loadBooks();
        
        // 7. FLASH MESSAGE
        session()->flash('message', 'Buku berhasil diterbitkan!');
    }

    public function delete($id) {
        $book = Book::find($id);

        if ($book && $book->user_id === Auth::id()) {
            // Hapus gambar cover dari storage jika ada
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            
            $book->delete();
            $this->loadBooks();
            session()->flash('message', 'Buku berhasil dihapus.');
        }
    }

    public function render() {
        return view('livewire.admin.manage-books')
            ->layout('layouts.app');
    }
}