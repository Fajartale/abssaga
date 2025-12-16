<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    // Mengizinkan mass assignment (create/update) untuk semua kolom kecuali id
    protected $guarded = ['id'];

    /**
     * Relasi: Sebuah Buku dimiliki oleh satu User (Penulis).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Sebuah Buku memiliki banyak Chapter.
     * Kita urutkan otomatis berdasarkan kolom 'order' agar rapi saat dipanggil.
     */
    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)->orderBy('order', 'asc');
    }
}