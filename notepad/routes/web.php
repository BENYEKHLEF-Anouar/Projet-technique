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

    Route::resource('notes', NoteController::class);
});
