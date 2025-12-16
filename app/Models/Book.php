<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'synopsis',
        'cover_image',
        'is_published', // Pastikan kolom ini ada di migration jika ingin dipakai
    ];

    /**
     * Relasi: Buku dimiliki oleh satu User (Penulis).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Buku memiliki banyak Chapter.
     * Diurutkan berdasarkan kolom 'order' (urutan bab).
     */
    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)->orderBy('order', 'asc');
    }

    /**
     * Accessor helper untuk URL cover.
     * Cara pakai: $book->cover_url
     */
    public function getCoverUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        
        // Return null atau path gambar default jika tidak ada cover
        return null; 
    }
}