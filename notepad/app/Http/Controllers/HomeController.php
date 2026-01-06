<?php

namespace App\Http\Controllers;

use App\Services\NoteService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //     Laravel automatically injects:
    // Request $request: Gives access to query parameters, form data, headers, etc.
    // NoteService $noteService: Resolved from the service container.
    
    public function index(Request $request, NoteService $noteService)
    {
        $notes = $noteService->getNotes(
            $request->input('search'),  // Gets the search query parameter (e.g., ?search=meeting).
            $request->input('category') // Gets the category query parameter (e.g., ?category=3).
        );

        return view('notes.index', compact('notes')); // compact('notes') is shorthand for: ['notes' => $notes]

    }
}
