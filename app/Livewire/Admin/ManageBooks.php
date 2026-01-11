<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Book;
use App\Models\Genre; // Import Model Genre
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManageBooks extends Component
{
    use WithFileUploads;

    public $bookId;
    public $title;
    public $synopsis;
    public $cover;
    public $old_cover;
    public $is_published = 0;
    
    // Properti Baru untuk Genre
    public $allGenres = []; 
    public $selectedGenres = []; // Array ID genre yang dipilih

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'synopsis' => 'required|min:10',
            'cover' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'selectedGenres' => 'required|array|min:1', // Wajib pilih minimal 1 genre
        ];
    }

    public function mount($id = null)
    {
        // Ambil semua genre untuk ditampilkan di pilihan
        $this->allGenres = Genre::orderBy('name')->get();

        if ($id) {
            // MODE EDIT
            $book = Book::where('user_id', Auth::id())->with('genres')->findOrFail($id);

            $this->bookId = $book->id;
            $this->title = $book->title;
            $this->synopsis = $book->synopsis;
            $this->is_published = (bool) $book->is_published;
            $this->old_cover = $book->cover_url;
            
            // Isi array selectedGenres dengan ID genre yang sudah tersimpan
            $this->selectedGenres = $book->genres->pluck('id')->toArray();
        } else {
            // MODE CREATE
            $this->bookId = null;
            $this->title = '';
            $this->synopsis = '';
            $this->is_published = 0;
            $this->old_cover = null;
            $this->selectedGenres = [];
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'synopsis' => $this->synopsis,
            'is_published' => $this->is_published ? 1 : 0,
        ];

        if ($this->cover) {
            $path = $this->cover->store('covers', 'public');
            $data['cover_image'] = $path;
        }

        if ($this->bookId) {
            // UPDATE
            $book = Book::where('user_id', Auth::id())->findOrFail($this->bookId);
            
            if ($this->cover && $book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            
            $book->update($data);
            
            // Sync Genre (Update relasi pivot)
            $book->genres()->sync($this->selectedGenres);

            session()->flash('message', 'Novel berhasil diperbarui!');
        } else {
            // CREATE
            $data['user_id'] = Auth::id();
            $data['slug'] = Str::slug($this->title) . '-' . Str::random(4);

            $book = Book::create($data);
            
            // Attach Genre (Simpan relasi pivot)
            $book->genres()->attach($this->selectedGenres);

            session()->flash('message', 'Novel baru berhasil dibuat!');
        }

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.admin.manage-books')->layout('layouts.blank');
    }
}