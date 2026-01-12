<?php

namespace App\Services;

use App\Models\Note;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NoteService extends BaseService
{
    // protected int $perPage = 10;

    /**
     * Retrieve a paginated list of notes, optionally filtered by search term and category.
     */
    public function getNotes(
        ?string $search = null,
        ?int $categoryId = null,
        ?int $perPage = null
    ): LengthAwarePaginator {
        $query = Note::query() // Starts a new Eloquent query on the notes table.
            ->with(['user', 'categories']) // Eager load relationships to prevent N+1 query problem.
            ->when($search, function ($query, $search) {
                // Apply search filter if search term is present.
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('content', 'LIKE', '%' . $search . '%')
                        ->orWhereHas('user', function ($uq) use ($search) {
                            $uq->where('name', 'LIKE', '%' . $search . '%');
                        });
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                // Apply category filter if category ID is present.
                $query->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                });
            });

        return $this->paginate($query, $perPage);
    }

    /**
     * Retrieve a single note by ID with its relationships.
     */
    public function getNote(int $id): Note
    {
        return Note::with(['user', 'categories'])->findOrFail($id);
    }

    /**
     * Create a new note in the database.
     */
    public function createNote(array $data): Note
    {
        $note = Note::create([
            'name' => $data['name'],
            'content' => $data['content'] ?? null,
            // Fallback to user ID 1 for testing if no authenticated user found.
            'user_id' => $data['user_id'] ?? Auth::id() ?? 1,
            'image' => $data['image'] ?? null,
        ]);

        // Sync categories if provided
        if (!empty($data['category_ids'])) {
            $note->categories()->sync($data['category_ids']);
        }

        return $note->load(['user', 'categories']);
    }

    /**
     * Create a new note and handle image upload if an image file is provided.
     */
    public function createNoteWithImage(array $data, $imageFile = null): Note
    {
        if ($imageFile) {
            // Store image in 'public/notes' directory and get the path.
            $path = $imageFile->store('notes', 'public');
            $data['image'] = $path;
        }
        return $this->createNote($data);
    }

    /**
     * Update an existing note's details.
     */
    public function updateNote(int $id, array $data): Note
    {
        $note = Note::findOrFail($id);

        $note->update([
            'name' => $data['name'] ?? $note->name,
            'content' => $data['content'] ?? $note->content,
            // Only update image if a new one is provided in the data array.
            'image' => array_key_exists('image', $data) ? $data['image'] : $note->image,
        ]);

        // Sync categories if provided
        if (array_key_exists('category_ids', $data)) {
            $note->categories()->sync($data['category_ids'] ?? []);
        }

        return $note->load(['user', 'categories']);
    }

    /**
     * Update an existing note, handling image replacement and deletion of the old image.
     */
    public function updateNoteWithImage(int $id, array $data, $imageFile = null): Note
    {
        $note = Note::findOrFail($id);
        if ($imageFile) {
            // Check for and delete the old image file to save space.
            if ($note->image && Storage::disk('public')->exists($note->image)) {
                Storage::disk('public')->delete($note->image);
            }
            // Store the new image.
            $path = $imageFile->store('notes', 'public');
            $data['image'] = $path;
        }
        return $this->updateNote($id, $data);
    }

    /**
     * Delete a note and detach its category relationships.
     */
    public function deleteNote(int $id): void
    {
        $note = Note::findOrFail($id);

        // Detach many-to-many relationships before deletion.
        $note->categories()->detach();

        $note->delete();
    }

    /**
     * Delete a note along with its associated image file from storage.
     */
    public function deleteNoteWithImage(int $id): void
    {
        $note = Note::findOrFail($id);
        // Delete the image file from storage if it exists.
        if ($note->image && Storage::disk('public')->exists($note->image)) {
            Storage::disk('public')->delete($note->image);
        }
        $this->deleteNote($id);
    }
}
