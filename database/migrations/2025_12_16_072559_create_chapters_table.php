<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel books
            // cascadeOnDelete artinya jika buku dihapus, semua chapter ikut terhapus
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
            
            $table->string('title'); // Judul Chapter (misal: Bab 1: Pertemuan)
            $table->string('slug');  // Slug chapter
            
            // Menggunakan longText agar bisa menampung tulisan yang sangat panjang
            $table->longText('content'); 
            
            // Urutan chapter (1, 2, 3...)
            $table->integer('order')->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};