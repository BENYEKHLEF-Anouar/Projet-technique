<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return redirect()->route('notes.index');
})->name('home');




Route::resource('notes', NoteController::class);