<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Chapter;

class ReadChapter extends Component
{
    public $chapter;

    public function mount($id)
    {
        // Load chapter beserta relasi buku agar bisa mengambil ID buku
        $this->chapter = Chapter::with('book')->findOrFail($id);
    }

    // Logic Tombol Previous
    public function getPrevChapter()
    {
        return Chapter::where('book_id', $this->chapter->book_id)
            ->where('order', '<', $this->chapter->order)
            ->orderBy('order', 'desc') // Ambil yang paling dekat sebelumnya
            ->first();
    }

    // Logic Tombol Next
    public function getNextChapter()
    {
        return Chapter::where('book_id', $this->chapter->book_id)
            ->where('order', '>', $this->chapter->order)
            ->orderBy('order', 'asc') // Ambil yang paling dekat setelahnya
            ->first();
    }

    public function render()
    {
        return view('livewire.public.read-chapter', [
            'prev' => $this->getPrevChapter(),
            'next' => $this->getNextChapter()
        ])->layout('layouts.public');
    }
}