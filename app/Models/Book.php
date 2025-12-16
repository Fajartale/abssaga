<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal (Mass Assignment).
     * Pastikan nama kolom ini sesuai dengan migration database.
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'synopsis',
        'cover_image',
    ];

    /**
     * Relasi: Sebuah Buku dimiliki oleh satu User (Penulis).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Sebuah Buku memiliki banyak Chapter.
     * Kita tambahkan 'orderBy' agar saat dipanggil ($book->chapters),
     * urutannya otomatis rapi dari bab 1, 2, dst.
     */
    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)->orderBy('order', 'asc');
    }

    /**
     * (Opsional) Accessor untuk mendapatkan URL Cover dengan mudah.
     * Cara pakai di Blade: <img src="{{ $book->cover_url }}">
     */
    public function getCoverUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }

        // Return null atau URL gambar placeholder default jika tidak ada cover
        return null; 
    }
}