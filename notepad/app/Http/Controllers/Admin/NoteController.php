<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\User;
use App\Services\NoteService;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    protected $noteService;
    protected $categoryService;

    public function __construct(NoteService $noteService, CategoryService $categoryService)
    {
        $this->noteService = $noteService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of notes
     */
    public function index(Request $request)
    {
        $notes = $this->noteService->getNotes(
            $request->input('search'),
            $request->input('category'),
            10 // items per page for admin
        );

        $categories = $this->categoryService->getAllCategories();

        if ($request->ajax()) {
            // Return only the notes table for AJAX requests
            return view('admin.notes._table', compact('notes'))->render();
        }
        return view('admin.notes.index', compact('notes', 'categories'));
    }

    /**
     * Show the form for creating a new note
     */
    public function create()
    {
        $categories = $this->categoryService->getAllCategories();
        $users = User::all();
        return view('admin.notes.form', compact('categories', 'users'));
    }

    /**
     * Store a newly created note in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'The note title is required.',
            'content.required' => 'Please add some content to your note.',
            'category_ids.required' => 'Please select at least one category.',
            'category_ids.min' => 'Please select at least one category.',
        ]);

        $note = $this->noteService->createNoteWithImage($validated, $request->file('image') ?? null);

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Note created successfully!',
                'note' => $note
            ]);
        }

        return redirect()->route('admin.notes.index')
            ->with('success', 'Note created successfully!');
    }

    /**
     * Display the specified note (for AJAX)
     */
    public function show(int $id)
    {
        $note = $this->noteService->getNote($id);

        return response()->json([
            'success' => true,
            'note' => $note->load(['categories', 'user'])
        ]);
    }

    /**
     * Show the form for editing the specified note (for AJAX)
     */
    public function edit(int $id)
    {
        $note = $this->noteService->getNote($id);

        // Return JSON for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'note' => $note->load(['categories', 'user'])
            ]);
        }

        $categories = $this->categoryService->getAllCategories();
        $users = User::all();
        return view('admin.notes.form', compact('note', 'categories', 'users'));
    }

    /**
     * Update the specified note in storage
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'The note title is required.',
            'content.required' => 'Please add some content to your note.',
            'category_ids.required' => 'Please select at least one category.',
            'category_ids.min' => 'Please select at least one category.',
        ]);

        $note = $this->noteService->updateNoteWithImage($id, $validated, $request->file('image') ?? null);

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Note updated successfully!',
                'note' => $note
            ]);
        }

        return redirect()->route('admin.notes.index')
            ->with('success', 'Note updated successfully!');
    }

    /**
     * Remove the specified note from storage
     */
    public function destroy(int $id)
    {
        $this->noteService->deleteNoteWithImage($id);

        return redirect()->route('admin.notes.index')
            ->with('success', 'Note deleted successfully!');
    }
}
