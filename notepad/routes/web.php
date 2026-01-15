<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

// Home route - redirect to notes
Route::get('/', function () {
    return redirect()->route('notes.index');
})->name('home');

// Routes pour les notes
Route::resource('notes', NoteController::class);