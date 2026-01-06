<?php

namespace App\Services;

use App\Models\Note;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NoteService
{
    public function getNotes(
        ?string $search = null,
        ?int $categoryId = null,
        int $perPage = 8
    ): LengthAwarePaginator {
        return Note::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'LIKE', '%' . $search . '%');
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->whereHas('categories', function ($query) use ($categoryId) { // use ($categoryId) imports the variable from the outer scope into the closure.
                    $query->where('categories.id', $categoryId);
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

    }
    public function getNote(int $id): Note // ensures the method returns a Note model instance.
    { // with() is Eager Loading in Laravel.
      // Load the user who owns the note (one-to-many relationship)
      // Load the categories the note belongs to (many-to-many relationship)

        return Note::with(['user', 'categories'])->findOrFail($id); // If not → throws a ModelNotFoundException, which usually results in a 404 HTTP response in a controller.
    }
}
