<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public function render()
    {
        $user = Auth::user();
        
        // Ambil data buku
        $books = $user->books()
            ->withCount('chapters')
            ->latest()
            ->paginate(5);
        
        // Hitung statistik
        $stats = [
            'books' => $user->books()->count(),
            'chapters' => $user->books()->withCount('chapters')->get()->sum('chapters_count'),
            'views' => 0,
        ];

        return view('livewire.dashboard', [
            'books' => $books,
            'stats' => $stats
        ])->layout('layouts.blank'); // <--- PERUBAHAN DI SINI (Ganti layouts.app jadi layouts.blank)
    }
}