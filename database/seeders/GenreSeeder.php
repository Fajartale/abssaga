<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $genres = ['Action', 'Romance', 'Fantasy', 'Horror', 'Sci-Fi', 'Comedy', 'Slice of Life', 'Mystery'];
    foreach ($genres as $name) {
        \App\Models\Genre::create([
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name)
        ]);
    }
}
}
