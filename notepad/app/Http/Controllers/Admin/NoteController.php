<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Services\CategoryService;
use App\Services\NoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoteController extends Controller
{
    // ... dependencies ...

    /**
     * JSON Search for Preline Combobox.
     */
    public function search(): JsonResponse
    {
        $notes = \App\Models\Note::with('categories')->latest()->get()->map(function ($note) {
            $category = $note->categories->first()->name ?? 'Uncategorized';
            $image = $note->image_url ?? 'https://placehold.co/600x400?text=No+Image'; // Fallback

            // Admin should ideally go to edit, but for search 'view' modal is safer/easier to link if we want "read mode".
            // However, typical search sends you to the resource. 
            // Let's allow public and admin to use this.
            // For now, return a generic structure. The frontend will decide the URL action?? 
            // Actually, the frontend snippet doesn't handle dynamic URLs easily without modifying the template.
            // Let's modify the response to include the full <a> tag as the name? No, that breaks accessibility.

            // We'll return data and let the frontend template usage decide.
            // Preline Combobox template is HTML string.

            return [
                'name' => $note->name,
                'category' => $category,
                'image' => $image,
                'id' => $note->id,
                'url' => route('notes.show', $note),
                'admin_url' => route('admin.notes.index') . '#note-' . $note->id
            ];
        });

        return response()->json($notes);
    }
    public function __construct(
        protected NoteService $noteService,
        protected CategoryService $categoryService
    ) {
    }

    /**
     * Display the Admin SPA Dashboard.
     */
    public function index(Request $request): View|string
    {
        // For the initial page load, we can pass data or let JS fetch it.
        // Given it's a simple SPA, passing initial data is efficient.
        $notes = $this->noteService->getPaginated(
            perPage: 10,
            search: $request->query('search'),
            categoryId: $request->query('category')
        );
        $categories = $this->categoryService->getAll();

        if ($request->ajax()) {
            return view('admin.notes.partials.list', compact('notes'))->render();
        }

        return view('admin.notes.index', compact('notes', 'categories'));
    }

    /**
     * Store a newly created note in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|string',
            'categories' => 'array|exists:categories,id',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        try {
            $note = $this->noteService->create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Note created successfully!',
                'note' => $note
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource (JSON for Modal).
     */
    public function edit(Note $note): JsonResponse
    {
        $note->load(['categories', 'user']);
        return response()->json($note);
    }

    /**
     * Update the specified note in storage.
     */
    public function update(Request $request, Note $note): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|string',
            'categories' => 'array|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        try {
            $updatedNote = $this->noteService->update($note, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Note updated successfully!',
                'note' => $updatedNote
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified note from storage.
     */
    public function destroy(Note $note): JsonResponse
    {
        try {
            $this->noteService->delete($note);
            return response()->json(['success' => true, 'message' => 'Note deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete note.'], 500);
        }
    }
}
