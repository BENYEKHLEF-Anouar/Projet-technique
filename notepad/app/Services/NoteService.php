<?php

namespace App\Services;

use App\Models\Note;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class NoteService
{
    public function getNotes(
        ?string $search = null,
        ?int $categoryId = null,
        int $perPage = 8
    ): LengthAwarePaginator {
        return Note::query()
            ->with(['user', 'categories'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%')
                      ->orWhere('content', 'LIKE', '%' . $search . '%')
                      ->orWhereHas('user', function ($uq) use ($search) {
                          $uq->where('name', 'LIKE', '%' . $search . '%');
                      });
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getNote(int $id): Note
    {
        return Note::with(['user', 'categories'])->findOrFail($id);
    }

    /**
     * Create a new note
     */
    public function createNote(array $data): Note
    {
        $note = Note::create([
            'name' => $data['name'],
            'content' => $data['content'] ?? null,
            'user_id' => $data['user_id'] ?? Auth::id() ?? 1,
            'image' => $data['image'] ?? null,
        ]);

        if (!empty($data['category_ids'])) {
            $note->categories()->sync($data['category_ids']);
        }

        return $note->load(['user', 'categories']);
    }

    /**
     * Update an existing note
     */
    public function updateNote(int $id, array $data): Note
    {
        $note = Note::findOrFail($id);

        $note->update([
            'name' => $data['name'] ?? $note->name,
            'content' => $data['content'] ?? $note->content,
            'image' => array_key_exists('image', $data) ? $data['image'] : $note->image,
        ]);

        if (array_key_exists('category_ids', $data)) {
            $note->categories()->sync($data['category_ids'] ?? []);
        }

        return $note->load(['user', 'categories']);
    }

    /**
     * Delete a note
     */
    public function deleteNote(int $id): void
    {
        $note = Note::findOrFail($id);

        // Detach relationships first (good practice for many-to-many)
        $note->categories()->detach();

        $note->delete();
    }
}
