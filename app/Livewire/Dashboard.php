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

        // Mengambil buku milik user yang login
        $books = $user->books()->withCount('chapters')->latest()->paginate(5);

        // Statistik Sederhana
        $totalBooks = $user->books()->count();
        $totalChapters = $user->books()->withCount('chapters')->get()->sum('chapters_count');
        // Placeholder Views (Jika nanti ada fitur view count)
        $totalViews = 0; 

        return view('livewire.dashboard', [
            'books' => $books,
            'stats' => [
                'books' => $totalBooks,
                'chapters' => $totalChapters,
                'views' => $totalViews,
            ]
        ])->layout('layouts.app'); // Pastikan menggunakan layout yang sudah ada (biasanya layouts.app untuk dashboard)
    }
}