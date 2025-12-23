<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage; // Tambahkan ini

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'synopsis',
        'cover_image',
        'is_published',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)->orderBy('order', 'asc');
    }

    /**
     * Accessor Cerdas untuk URL Cover
     * Memperbaiki masalah path 'public/' dan URL eksternal
     */
    public function getCoverUrlAttribute()
    {
        // 1. Jika tidak ada gambar, kembalikan placeholder atau null
        if (empty($this->cover_image)) {
            return null; // Nanti di Blade akan di-handle oleh '?? placeholder'
        }

        // 2. Jika gambar adalah URL eksternal (misal dari Seeder / Faker)
        if (filter_var($this->cover_image, FILTER_VALIDATE_URL)) {
            return $this->cover_image;
        }

        // 3. Bersihkan path jika tidak sengaja tersimpan dengan prefix 'public/'
        // Contoh: 'public/covers/foto.jpg' -> 'covers/foto.jpg'
        $cleanPath = str_replace('public/', '', $this->cover_image);

        // 4. Kembalikan URL asset storage yang benar
        return asset('storage/' . $cleanPath);
    }
}