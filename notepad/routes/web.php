<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

// Home route - redirect to notes
Route::get('/', function () {
    return redirect()->route('notes.index');
})->name('home');

// Routes pour les notes
Route::resource('notes', NoteController::class);

// Route::controller(NoteController::class)->prefix('notes')->name('notes.')->group(function () {
//     Route::get('/', 'index')->name('index');
//     Route::post('/', 'store')->name('store');
//     Route::get('/{note}', 'show')->name('show');
//     Route::put('/{note}', 'update')->name('update');
//     Route::delete('/{note}', 'destroy')->name('destroy');
// });