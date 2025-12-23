<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder; // Import Builder

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

    /**
     * Relasi ke Penulis (User)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Chapters (Urutkan dari Bab 1, 2, dst)
     */
    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)->orderBy('order', 'asc');
    }

    /**
     * Accessor Cerdas untuk URL Cover ($book->cover_url)
     * Menangani path 'public/', URL eksternal, atau null
     */
    public function getCoverUrlAttribute()
    {
        // 1. Jika kosong, return null (biar Blade pakai placeholder)
        if (empty($this->cover_image)) {
            return null;
        }

        // 2. Jika URL eksternal (misal dummy data), return langsung
        if (filter_var($this->cover_image, FILTER_VALIDATE_URL)) {
            return $this->cover_image;
        }

        // 3. Bersihkan prefix 'public/' jika tersimpan salah di DB
        $cleanPath = str_replace('public/', '', $this->cover_image);

        // 4. Return URL asset yang benar
        return asset('storage/' . $cleanPath);
    }

    /**
     * SCOPE PENCARIAN (Anti Bocor)
     * Membungkus logika OR dalam tanda kurung agar tidak merusak filter lain
     * Cara pakai: Book::search('keyword')->get();
     */
    public function scopeSearch(Builder $query, $term)
    {
        // Jika tidak ada keyword, kembalikan query apa adanya
        if (!$term) {
            return $query;
        }

        // Filter dengan grouping (WHERE (title LIKE ... OR synopsis LIKE ...))
        return $query->where(function ($q) use ($term) {
            $wildcard = "%{$term}%";
            
            $q->where('title', 'like', $wildcard)
              ->orWhere('synopsis', 'like', $wildcard)
              // Cari juga berdasarkan nama penulis
              ->orWhereHas('user', function ($subQuery) use ($wildcard) {
                  $subQuery->where('name', 'like', $wildcard);
              });
        });
    }
}