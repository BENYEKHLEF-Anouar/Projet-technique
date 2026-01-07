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
            'content' => 'nullable|string',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('notes', 'public');
            $validated['image'] = $path;
        }

        $this->noteService->createNote($validated);

        return redirect()->route('admin.notes.index')
            ->with('success', 'Note created successfully!');
    }

    /**
     * Show the form for editing the specified note
     */
    public function edit(int $id)
    {
        $note = $this->noteService->getNote($id);
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
            'content' => 'nullable|string',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $note = Note::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($note->image && Storage::disk('public')->exists($note->image)) {
                Storage::disk('public')->delete($note->image);
            }

            $path = $request->file('image')->store('notes', 'public');
            $validated['image'] = $path;
        }

        $this->noteService->updateNote($id, $validated);

        return redirect()->route('admin.notes.index')
            ->with('success', 'Note updated successfully!');
    }

    /**
     * Remove the specified note from storage
     */
    public function destroy(int $id)
    {
        $note = Note::findOrFail($id);

        // Delete image if exists
        if ($note->image && Storage::disk('public')->exists($note->image)) {
            Storage::disk('public')->delete($note->image);
        }

        $this->noteService->deleteNote($id);

        return redirect()->route('admin.notes.index')
            ->with('success', 'Note deleted successfully!');
    }
}
