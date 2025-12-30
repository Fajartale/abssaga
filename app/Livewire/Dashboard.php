<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage; // Tambahkan ini untuk hapus gambar

class Dashboard extends Component
{
    use WithPagination;

    // Fungsi untuk menghapus buku
    public function deleteBook($id)
    {
        // Cari buku milik user yang sedang login
        $book = Auth::user()->books()->find($id);

        if ($book) {
            // 1. Hapus file cover jika ada (opsional, agar hemat storage)
            if ($book->cover_image) {
                // Pastikan path sesuai dengan cara Anda menyimpan (pakai 'public/' atau tidak)
                $path = str_replace('public/', '', $book->cover_image);
                Storage::disk('public')->delete($path);
            }

            // 2. Hapus data buku
            $book->delete();

            // 3. Kirim notifikasi (opsional)
            session()->flash('message', 'Novel berhasil dihapus!');
        }
    }

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
            // Menggunakan sum dari hasil get() agar akurat
            'chapters' => $user->books()->withCount('chapters')->get()->sum('chapters_count'),
            'views' => 0, // Belum ada kolom views di database, default 0
        ];

        return view('livewire.dashboard', [
            'books' => $books,
            'stats' => $stats
        ])->layout('layouts.blank');
    }
}