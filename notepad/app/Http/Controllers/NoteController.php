<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Services\CategoryService;
use App\Services\NoteService;
use Illuminate\Http\Request;

class NoteController extends Controller
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
        
        if ($request->wantsJson()) {
            return response()->json($notes);
        }

        $categories = $this->categoryService->getAllCategories();

        return view('admin.notes.index', compact('notes', 'categories'));
    }

    public function store(StoreNoteRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id() ?? 1;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $note = $this->noteService->create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('note.views.success') ?? 'Note created successfully!',
                'note' => $note
            ]);
        }

        return redirect()->route('notes.index')->with('success', __('note.views.success') ?? 'Note created successfully!');
    }

    public function show($id)
    {
        $note = $this->noteService->getNote($id);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'note' => $note->load('categories'),
                'image_url' => $note->image ? asset('storage/' . $note->image) : null,
                'categories' => $note->categories->pluck('id')
            ]);
        }

        return view('admin.notes.show', compact('note'));
    }

    public function update(UpdateNoteRequest $request, $id)
    {
        $note = $this->noteService->getNote($id);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $updatedNote = $this->noteService->update($note, $data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('note.views.updated_success') ?? 'Note updated successfully!',
                'note' => $updatedNote
            ]);
        }

        return redirect()->route('notes.index')->with('success', __('note.views.updated_success') ?? 'Note updated successfully!');
    }

    public function destroy($id)
    {
        $note = $this->noteService->getNote($id);
        $this->noteService->delete($note);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('note.views.deleted_success') ?? 'Note deleted successfully!',
            ]);
        }

        return redirect()->route('notes.index')->with('success', __('note.views.deleted_success') ?? 'Note deleted successfully!');
    }
}