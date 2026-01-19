<?php

namespace App\Services;

use App\Models\Note;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NoteService extends BaseService
{
    /**
     * Retrieve a paginated list of notes, optionally filtered by search term and category.
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Note::with(['user', 'categories']);

        // Search by name
        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        // Filter by category
        if (!empty($filters['category_id'])) {
            $query->whereHas('categories', function ($q) use ($filters) {
                $q->where('categories.id', $filters['category_id']);
            });
        }

        // Pagination
        return $this->paginate($query);
    }

    /**
     * Create a new note.
     */
    public function create(array $data): Note
    {
        // Upload image
        if (!empty($data['image'])) {
            $data['image'] = $data['image']->store('notes', 'public');
        }

        $note = Note::create($data);

        // Associate categories
        if (!empty($data['category_ids'])) {
            $note->categories()->sync($data['category_ids']);
        }

        return $note;
    }

    /**
     * Update an existing note.
     */
    public function update(Note $note, array $data): Note
    {
        // Upload image
        if (!empty($data['image'])) {
            $data['image'] = $data['image']->store('notes', 'public');
        }

        $note->update($data);

        // Associate categories
        if (!empty($data['category_ids'])) {
            $note->categories()->sync($data['category_ids']);
        }

        return $note;
    }

    /**
     * Delete a note.
     */
    public function delete(Note $note): void
    {
        $note->delete();
    }

    /**
     * Get a single note (Helper for show methods)
     */
    public function getNote(int $id): Note
    {
        return Note::with(['categories'])->findOrFail($id);
    }
}
