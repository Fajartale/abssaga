<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ManageBook extends Component
{
    use WithFileUploads;

    public $bookId;
    public $title;
    public $synopsis;
    public $cover; // Untuk file upload baru
    public $old_cover; // Untuk menyimpan url cover lama (saat edit)
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
            // EDIT MODE
            $book = Book::where('user_id', Auth::id())->findOrFail($id);
            $this->bookId = $book->id;
            $this->title = $book->title;
            $this->synopsis = $book->synopsis;
            $this->is_published = $book->is_published;
            $this->old_cover = $book->cover_url; // Pastikan di model Book ada accessor/kolom cover_url
        }
    }

    public function save()
    {
        $this->validate();

        // 1. Handle File Upload
        $coverPath = null;
        if ($this->cover) {
            // Simpan ke storage/app/public/covers
            $coverPath = $this->cover->store('covers', 'public');
        }

        // 2. Simpan atau Update Database
        if ($this->bookId) {
            // Update Existing Book
            $book = Book::where('user_id', Auth::id())->findOrFail($this->bookId);
            $updateData = [
                'title' => $this->title,
                'synopsis' => $this->synopsis,
                'is_published' => $this->is_published,
            ];

            // Hanya update cover jika user upload baru
            if ($coverPath) {
                // Opsional: Hapus cover lama dari storage jika perlu
                $updateData['cover_path'] = $coverPath; // Sesuaikan dengan nama kolom di DB Anda
            }

            $book->update($updateData);
            session()->flash('message', 'Novel berhasil diperbarui!');
        } else {
            // Create New Book
            Book::create([
                'user_id' => Auth::id(),
                'title' => $this->title,
                'synopsis' => $this->synopsis,
                'is_published' => $this->is_published,
                'cover_path' => $coverPath, // Sesuaikan dengan nama kolom di DB Anda
            ]);
            session()->flash('message', 'Novel baru berhasil diterbitkan!');
        }

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.manage-book')->layout('layouts.blank');
    }
}