<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users (penulis)
            // cascadeOnDelete artinya jika user dihapus, bukunya ikut terhapus
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->string('title');
            $table->string('slug')->unique(); // Untuk URL SEO friendly (contoh: judul-buku-keren)
            $table->string('cover_image')->nullable(); // Bisa kosong jika belum ada cover
            $table->text('synopsis'); // Text area untuk sinopsis
            
            // Status (opsional, untuk filter yang tampil di landing page)
            $table->boolean('is_published')->default(true); 
            
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};