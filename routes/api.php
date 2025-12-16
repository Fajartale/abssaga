<?php

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/books', function () {
    return Book::with('user')->latest()->paginate(10);
});

Route::get('/books/{id}', function ($id) {
    return Book::with(['chapters', 'user'])->findOrFail($id);
});