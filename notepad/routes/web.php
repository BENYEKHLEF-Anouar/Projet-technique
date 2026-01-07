<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\NoteController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/notes/{id}', [HomeController::class, 'show'])->name('notes.show');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Route::resource('notes', NoteController::class);

    // Note Routes
    Route::get('notes', [NoteController::class, 'index'])->name('notes.index');
    Route::get('notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('notes/{note}', [NoteController::class, 'show'])->name('notes.show');
    Route::get('notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
});
