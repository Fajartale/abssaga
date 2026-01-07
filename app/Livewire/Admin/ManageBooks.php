<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // [PENTING] Untuk buat Slug otomatis

class ManageBooks extends Component
{
    use WithFileUploads;

    public $bookId;
    public $title;
    public $synopsis;
    public $cover;       
    public $old_cover;   
    public $is_published = 0; 

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'synopsis' => 'required|min:10',
            'cover' => 'nullable|image|max:2048', 
            'is_published' => 'boolean'
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            // --- MODE EDIT ---
            $book = Book::where('user_id', Auth::id())->findOrFail($id);

            $this->bookId = $book->id;
            $this->title = $book->title;
            $this->synopsis = $book->synopsis;
            $this->is_published = $book->is_published;
            $this->old_cover = $book->cover_url; 
        } else {
            // --- MODE ADD (RESET) ---
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
            'slug' => Str::slug($this->title) . '-' . Str::random(4), // Buat slug unik
            'synopsis' => $this->synopsis,
            'is_published' => $this->is_published ? 1 : 0,
        ];

        // 2. Cek Upload Cover
        if ($this->cover) {
            $path = $this->cover->store('covers', 'public');
            $data['cover_image'] = $path; // [PERBAIKAN] Sesuaikan dengan nama kolom di DB (cover_image)
        }

        // 3. Simpan (Create / Update)
        if ($this->bookId) {
            // UPDATE
            $book = Book::where('user_id', Auth::id())->findOrFail($this->bookId);
            
            // Hapus slug dari array update agar slug tidak berubah saat edit (opsional, bagus untuk SEO)
            unset($data['slug']); 
            
            // Jika tidak ada cover baru, jangan update kolom cover
            if (!$this->cover) {
                unset($data['cover_image']);
            }

            $book->update($data);
            session()->flash('message', 'Novel berhasil diperbarui!');
            
        } else {
            // CREATE
            $data['user_id'] = Auth::id(); // Set Penulis
            Book::create($data);
            session()->flash('message', 'Novel baru berhasil dibuat! Silakan tambah chapter.');
        }

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.admin.manage-books')->layout('layouts.blank');
    }
}