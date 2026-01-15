<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\NoteService;
use Illuminate\Http\Request;

class NoteController extends Controller {

protected NoteService $noteService;
protected CategoryService $categoryService;


public function __construct(NoteService $noteService, CategoryService $categoryService)
{
    $this->noteService = $noteService;
    $this->categoryService = $categoryService;
}

public function index (Request $request) {

    $notes = $this->noteService->getAll([
        'search' => $request->input('search'),
        'category_id' => $request->input('category_id')
    ]);

    $categories = $this->categoryService->getAllCategories();



    if ($request->ajax()) {
        return view('admin.notes._table_body', compact('notes'))->render();
    }



    return view('admin.notes.index', compact('notes', 'categories'));

}


public function store(Request $request) {
    
    $data = $request->validate([
        'name' => 'required|string|max:300',
        'content' => 'required|string',
        'category_ids' => 'nullable|array',
        'category_ids.*' => 'exists:categories,id',
        'image' => 'nullable|image|max:3000'

    ]);

    // $data['user_id'] = auth()->id() ?? 1;
    $data['user_id'] = 1;


    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image');
    }

    
    $this->noteService->create($data);
    
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => __('note.views.success') ?? 'Note created with success!',
        ]);
    }


    return redirect()->route('notes.index')->with('success', __('note.views.success') ?? 'Note created with success!');
}








}

