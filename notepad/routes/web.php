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

// Routes pour les notes
Route::resource('notes', NoteController::class);

// Route::controller(NoteController::class)->prefix('notes')->name('notes.')->group(function () {
//     Route::get('/', 'index')->name('index');
//     Route::post('/', 'store')->name('store');
//     Route::get('/{note}', 'show')->name('show');
//     Route::put('/{note}', 'update')->name('update');
//     Route::delete('/{note}', 'destroy')->name('destroy');
// });