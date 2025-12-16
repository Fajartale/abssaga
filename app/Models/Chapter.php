<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chapter extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi.
     * Sesuai dengan migration chapters table.
     */
    protected $fillable = [
        'book_id',
        'title',
        'slug',
        'content',
        'order',
    ];

    /**
     * Relasi: Chapter adalah milik satu Buku.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}