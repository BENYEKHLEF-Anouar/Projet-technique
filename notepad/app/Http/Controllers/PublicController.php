<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\NoteService;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    protected NoteService $noteService;
    protected CategoryService $categoryService;

    public function __construct(NoteService $noteService, CategoryService $categoryService)
    {
        $this->noteService = $noteService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $notes = $this->noteService->getAll([
            'search' => $request->input('search'),
            'category_id' => $request->input('category_id')
        ]);
        $categories = $this->categoryService->getAllCategories();

        if ($request->ajax()) {
            return view('public._notes_wrapper', compact('notes'))->render();
        }

        return view('public.index', compact('notes', 'categories'));
    }

    public function show($id)
    {
        $note = $this->noteService->getNote($id);
        return view('public.show', compact('note'));
    }
}
