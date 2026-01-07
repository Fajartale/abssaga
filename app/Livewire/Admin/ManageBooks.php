<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManageBooks extends Component
{
    use WithFileUploads;

    public $bookId;
    public $title;
    public $synopsis;
    public $cover;       // File gambar baru (dari form upload)
    public $old_cover;   // URL gambar lama (dari database)
    public $is_published = 0;

    // Aturan Validasi
    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'synopsis' => 'required|min:10',
            'cover' => 'nullable|image|max:2048', // Maksimal 2MB
            'is_published' => 'boolean'
        ];
    }

    /**
     * Mount dijalankan saat komponen dimuat.
     * Menerima parameter $id dari Route (jika ada).
     */
    public function mount($id = null)
    {
        if ($id) {
            // --- MODE EDIT ---
            // Cari buku berdasarkan ID dan pastikan milik user yang login
            $book = Book::where('user_id', Auth::id())->findOrFail($id);

            $this->bookId = $book->id;
            $this->title = $book->title;
            $this->synopsis = $book->synopsis;
            $this->is_published = (bool) $book->is_published;
            
            // Ambil URL cover dari accessor di Model Book
            $this->old_cover = $book->cover_url; 
        } else {
            // --- MODE CREATE ---
            // Reset semua field agar form kosong
            $this->bookId = null;
            $this->title = '';
            $this->synopsis = '';
            $this->is_published = 0;
            $this->old_cover = null;
        }
    }

    public function save()
    {
        $this->validate();

        // 1. Siapkan Data Dasar
        $data = [
            'title' => $this->title,
            'synopsis' => $this->synopsis,
            'is_published' => $this->is_published ? 1 : 0,
        ];

        // 2. Handle Upload Cover
        if ($this->cover) {
            // Simpan gambar ke storage/app/public/covers
            $path = $this->cover->store('covers', 'public');
            // Simpan path ke database (nama kolom: cover_image)
            $data['cover_image'] = $path;
        }

        // 3. Simpan ke Database
        if ($this->bookId) {
            // === UPDATE BUKU LAMA ===
            $book = Book::where('user_id', Auth::id())->findOrFail($this->bookId);

            // Hapus file cover lama jika user mengupload cover baru (Opsional)
            if ($this->cover && $book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $book->update($data);
            session()->flash('message', 'Novel berhasil diperbarui!');

        } else {
            // === BUAT BUKU BARU ===
            $data['user_id'] = Auth::id();
            // Buat Slug Unik (contoh: judul-buku-a1b2)
            $data['slug'] = Str::slug($this->title) . '-' . Str::random(4);

            Book::create($data);
            session()->flash('message', 'Novel baru berhasil dibuat! Silakan tambah chapter.');
        }

        // Redirect kembali ke Dashboard
        return redirect()->route('dashboard');
    }

    public function render()
    {
        // Pastikan view mengarah ke folder yang benar
        return view('livewire.admin.manage-books')->layout('layouts.blank');
    }
}