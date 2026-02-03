<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [PublicController::class, 'index'])->name('public.index');
Route::get('/note/{note}', [PublicController::class, 'show'])->name('public.show');

// Language Switch
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

// Routes for notes (admin area)
Route::resource('notes', NoteController::class);

Auth::routes();
