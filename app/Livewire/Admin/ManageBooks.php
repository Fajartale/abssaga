<?php

namespace App\Livewire\Admin; // [Perbaikan 1] Tambahkan \Admin

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ManageBooks extends Component // [Perbaikan 2] Ubah jadi 'ManageBooks' (sesuai nama file)
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
            $book = Book::where('user_id', Auth::id())->findOrFail($id);
            $this->bookId = $book->id;
            $this->title = $book->title;
            $this->synopsis = $book->synopsis;
            $this->is_published = $book->is_published;
            $this->old_cover = $book->cover_url;
        }
    }

    public function save()
    {
        $this->validate();

        $coverPath = null;
        if ($this->cover) {
            $coverPath = $this->cover->store('covers', 'public');
        }

        if ($this->bookId) {
            $book = Book::where('user_id', Auth::id())->findOrFail($this->bookId);
            
            $updateData = [
                'title' => $this->title,
                'synopsis' => $this->synopsis,
                'is_published' => $this->is_published,
            ];

            if ($coverPath) {
                $updateData['cover_path'] = $coverPath;
            }

            $book->update($updateData);
            
        } else {
            Book::create([
                'user_id' => Auth::id(),
                'title' => $this->title,
                'synopsis' => $this->synopsis,
                'is_published' => $this->is_published,
                'cover_path' => $coverPath,
            ]);
        }

        return redirect()->route('dashboard');
    }

    public function render()
    {
        // [Perbaikan 3] Sesuaikan path view dengan folder resources/views/livewire/admin/manage-books.blade.php
        return view('livewire.admin.manage-books')->layout('layouts.blank');
    }
}