<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\NoteService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VisitorController extends Controller
{
    public function __construct(
        protected NoteService $noteService,
        protected CategoryService $categoryService
    ) {
    }

    /**
     * Display the public home page with notes.
     */
    public function index(Request $request): View|string
    {
        $notes = $this->noteService->getPaginated(
            9,
            $request->query('search'),
            $request->query('category')
        );

        $categories = \App\Models\Category::all();

        if ($request->ajax()) {
            return view('partials.notes-grid', compact('notes'))->render();
        }

        return view('welcome', compact('notes', 'categories'));
    }

    /**
     * Display the specified note.
     */
    public function show(\App\Models\Note $note): View
    {
        return view('notes.show', compact('note'));
    }
}
