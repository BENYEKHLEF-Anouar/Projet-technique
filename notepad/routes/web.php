<?php

use App\Http\Controllers\VisitorController;
use App\Http\Controllers\Admin\NoteController;

use Illuminate\Support\Facades\Route;

// Public Visitor Routes
Route::get('/', [VisitorController::class, 'index'])->name('home');
Route::get('/notes/{note}', [VisitorController::class, 'show'])->name('notes.show');

// Language Switcher
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');

// Search API
Route::get('/notes/search', [\App\Http\Controllers\Admin\NoteController::class, 'search'])->name('notes.search');

// Admin Routes (Prefix: admin)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [NoteController::class, 'index'])->name('dashboard');
    Route::resource('notes', NoteController::class)->except(['create', 'show']);
});