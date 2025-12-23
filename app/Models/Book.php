<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; // Tambahkan ini

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'slug', 'synopsis', 'cover_image', 'is_published'];

    // ... relations (user, chapters) ...
    public function user() { return $this->belongsTo(User::class); }
    public function chapters() { return $this->hasMany(Chapter::class)->orderBy('order', 'asc'); }
    
    // ... accessor (getCoverUrlAttribute) ...
    public function getCoverUrlAttribute() { /* kode yang sudah diperbaiki sebelumnya */ }

    /**
     * --- TAMBAHKAN SCOPE INI ---
     * Fungsi ini membungkus logika pencarian agar "OR" tidak bocor.
     */
    public function scopeSearch(Builder $query, $term)
    {
        if (!$term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $term = "%{$term}%";
            $q->where('title', 'like', $term)
              ->orWhere('synopsis', 'like', $term)
              ->orWhereHas('user', function ($subQ) use ($term) {
                  $subQ->where('name', 'like', $term);
              });
        });
    }
}