<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads; // Wajib untuk upload file
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ManageBooks extends Component
{
    use WithFileUploads;

    public $bookId;
    public $title;
    public $synopsis;
    public $cover;       // Menampung file baru yang diupload
    public $old_cover;   // Menampung URL cover lama (untuk preview saat edit)
    public $is_published = 0; // Default Draft (0)

    // Rules Validasi
    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'synopsis' => 'required|min:10',
            'cover' => 'nullable|image|max:2048', // Max 2MB, format gambar
            'is_published' => 'boolean'
        ];
    }

    // Mount dijalankan saat halaman pertama kali dimuat
    // Jika ada ID ($id), berarti mode EDIT
    public function mount($id = null)
    {
        if ($id) {
            // Cari buku milik user yang sedang login (Security Check)
            $book = Book::where('user_id', Auth::id())->findOrFail($id);

            // Isi form dengan data database
            $this->bookId = $book->id;
            $this->title = $book->title;
            $this->synopsis = $book->synopsis;
            $this->is_published = $book->is_published;
            $this->old_cover = $book->cover_url; // Pastikan model Book punya akses ke url cover (accessor)
        }
    }

    public function save()
    {
        $this->validate();

        // 1. Proses Upload Cover (Jika ada file baru)
        $coverPath = null;
        if ($this->cover) {
            // Simpan di folder: storage/app/public/covers
            $coverPath = $this->cover->store('covers', 'public');
        }

        // 2. Simpan ke Database
        if ($this->bookId) {
            // --- UPDATE (Edit Buku Lama) ---
            $book = Book::where('user_id', Auth::id())->findOrFail($this->bookId);
            
            $updateData = [
                'title' => $this->title,
                'synopsis' => $this->synopsis,
                'is_published' => $this->is_published,
            ];

            // Hanya update path cover jika user mengupload gambar baru
            if ($coverPath) {
                $updateData['cover_path'] = $coverPath;
                // Opsional: Hapus file lama jika perlu menggunakan Storage::delete()
            }

            $book->update($updateData);
            
        } else {
            // --- CREATE (Buat Buku Baru) ---
            Book::create([
                'user_id' => Auth::id(),
                'title' => $this->title,
                'synopsis' => $this->synopsis,
                'is_published' => $this->is_published,
                'cover_path' => $coverPath,
            ]);
        }

        // Redirect kembali ke Dashboard setelah simpan
        return redirect()->route('dashboard');
    }

    public function render()
    {
        // Pastikan view ini ada di: resources/views/livewire/admin/manage-books.blade.php
        return view('livewire.admin.manage-books')->layout('layouts.blank');
    }
}