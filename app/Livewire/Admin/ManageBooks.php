<?php

namespace App\Livewire\Admin; // [PERBAIKAN 1] Namespace harus mengarah ke folder Admin

use Livewire\Component;
use Livewire\WithFileUploads; // Wajib untuk fitur upload gambar
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // [PERBAIKAN 2] Import Str untuk pembuatan Slug

class ManageBooks extends Component // [PERBAIKAN 3] Nama Class HARUS sama dengan Nama File (ManageBooks)
{
    use WithFileUploads;

    public $bookId;
    public $title;
    public $synopsis;
    public $cover;       // Menampung file baru dari input form
    public $old_cover;   // Menampung URL cover lama dari database
    public $is_published = 0; // Default: Draft

    // Rules Validasi
    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'synopsis' => 'required|min:10',
            'cover' => 'nullable|image|max:2048', // Max 2MB, harus gambar
            'is_published' => 'boolean'
        ];
    }

    /**
     * Method mount dijalankan sekali saat komponen dimuat.
     * Menerima parameter $id dari URL (jika ada).
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
            
            // Mengambil URL cover lama (pastikan ada accessor di Model Book atau gunakan asset)
            $this->old_cover = $book->cover_url; 
        } else {
            // --- MODE CREATE (Buat Baru) ---
            // Reset semua field
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

        // 1. Siapkan data dasar
        $data = [
            'title' => $this->title,
            'synopsis' => $this->synopsis,
            'is_published' => $this->is_published ? 1 : 0,
        ];

        // 2. Proses Upload Cover (Jika ada file baru)
        if ($this->cover) {
            // Simpan ke storage/app/public/covers
            $path = $this->cover->store('covers', 'public');
            $data['cover_image'] = $path; // Sesuaikan dengan nama kolom di Database
        }

        // 3. Simpan ke Database
        if ($this->bookId) {
            // === UPDATE ===
            $book = Book::where('user_id', Auth::id())->findOrFail($this->bookId);
            
            // Hapus file lama jika ada cover baru (Opsional)
            if ($this->cover && $book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            
            // Jangan update slug saat edit agar link tidak rusak (Opsional)
            // $data['slug'] = Str::slug($this->title); 

            $book->update($data);
            session()->flash('message', 'Novel berhasil diperbarui!');
            
        } else {
            // === CREATE ===
            $data['user_id'] = Auth::id();
            // Buat slug unik saat membuat buku baru
            $data['slug'] = Str::slug($this->title) . '-' . Str::random(4);

            Book::create($data);
            session()->flash('message', 'Novel baru berhasil dibuat! Silakan tambah chapter.');
        }

        // Redirect kembali ke Dashboard
        return redirect()->route('dashboard');
    }

    public function render()
    {
        // [PERBAIKAN 4] Arahkan ke view yang benar di folder admin
        return view('livewire.admin.manage-books')->layout('layouts.blank');
    }
}