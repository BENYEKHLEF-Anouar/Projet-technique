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
        return Note::query() // Starts a new Eloquent query on the notes table.
            ->when($search, function ($query, $search) {
                $query->where('title', 'LIKE', '%' . $search . '%');
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();  // Keeps existing URL query parameters (e.g. search, category), Keeps existing URL query parameters (e.g. search, category) : ?search=test&category=2&page=2

    }
}
