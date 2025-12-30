<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ManageBooks extends Component
{
    use WithFileUploads;

    public $bookId;
    public $title;
    public $synopsis;
    public $cover;       // File baru (temporary)
    public $old_cover;   // URL cover lama (dari database)
    public $is_published = false;

    // Rules Validasi
    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'synopsis' => 'required|min:10',
            'cover' => 'nullable|image|max:2048', // Max 2MB
            'is_published' => 'boolean'
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            // Mode EDIT: Ambil data dari database
            // Security: Pastikan hanya pemilik buku yang bisa edit
            $book = Book::where('user_id', Auth::id())->findOrFail($id);

            $this->bookId = $book->id;
            $this->title = $book->title;
            $this->synopsis = $book->synopsis;
            $this->is_published = (bool) $book->is_published;
            
            // Asumsi di Model Book ada accessor/helper untuk url cover
            // Jika tidak ada, bisa ganti manual: asset('storage/' . $book->cover_path)
            $this->old_cover = $book->cover_path ? asset('storage/' . $book->cover_path) : null; 
        }
    }

    public function save()
    {
        $this->validate();

        // 1. Tentukan Data Dasar
        $data = [
            'title' => $this->title,
            'synopsis' => $this->synopsis,
            'is_published' => $this->is_published ? 1 : 0,
        ];

        // 2. Cek apakah ada file cover baru yang diupload
        if ($this->cover) {
            // Simpan file ke storage/app/public/covers
            $path = $this->cover->store('covers', 'public');
            $data['cover_path'] = $path;

            // Opsional: Hapus cover lama jika mode Edit (untuk hemat storage)
            // if ($this->bookId && $this->old_cover) { ... }
        }

        // 3. Simpan ke Database (Create atau Update)
        if ($this->bookId) {
            // Update Buku Lama
            $book = Book::where('user_id', Auth::id())->findOrFail($this->bookId);
            $book->update($data);
            session()->flash('message', 'Novel berhasil diperbarui!');
        } else {
            // Buat Buku Baru
            $data['user_id'] = Auth::id(); // Set Penulis
            Book::create($data);
            session()->flash('message', 'Novel baru berhasil dibuat!');
        }

        // Redirect ke Dashboard
        return redirect()->route('dashboard');
    }

    public function render()
    {
        // Layout bisa diganti ke 'layouts.app' jika ingin ada sidebar/navbar dashboard
        return view('livewire.admin.manage-books')->layout('layouts.blank');
    }
}