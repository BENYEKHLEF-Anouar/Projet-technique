<?php

namespace App\Services;

use App\Models\Note;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoteService extends BaseService
{
    /**
     * Get notes with pagination and optional search/filter.
     *
     * @param int $perPage
     * @param string|null $search
     * @param int|null $categoryId
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage = 10, ?string $search = null, ?int $categoryId = null): LengthAwarePaginator
    {
        $query = Note::with('categories', 'user')->latest();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
        }

        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Create a new note.
     *
     * @param array $data
     * @return Note
     */
    public function create(array $data): Note
    {
        return DB::transaction(function () use ($data) {
            $noteData = [
                'user_id' => $data['user_id'] ?? Auth::id() ?? 1, // Fallback to 1 for dev if no auth
                'name' => $data['name'],
                'content' => $data['content'] ?? null,
            ];

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $noteData['image'] = $this->uploadFile($data['image'], 'notes');
            } elseif (isset($data['image_url']) && !empty($data['image_url'])) {
                $noteData['image'] = $data['image_url'];
            }

            $note = Note::create($noteData);

            if (!empty($data['categories'])) {
                $note->categories()->attach($data['categories']);
            }

            return $note;
        });
    }

    /**
     * Update a note.
     *
     * @param Note $note
     * @param array $data
     * @return Note
     */
    public function update(Note $note, array $data): Note
    {
        return DB::transaction(function () use ($note, $data) {
            $updateData = [
                'name' => $data['name'],
                'content' => $data['content'] ?? $note->content,
            ];

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $this->deleteFile($note->image);
                $updateData['image'] = $this->uploadFile($data['image'], 'notes');
            } elseif (isset($data['image_url']) && !empty($data['image_url'])) {
                // Check if it's a new URL different from existing (avoid deleting local if same)
                if ($note->image !== $data['image_url']) {
                    // Only delete old file if it wasn't a URL
                    if ($note->image && !str_starts_with($note->image, 'http')) {
                        $this->deleteFile($note->image);
                    }
                    $updateData['image'] = $data['image_url'];
                }
            }

            $note->update($updateData);

            if (isset($data['categories'])) {
                $note->categories()->sync($data['categories']);
            }

            return $note->refresh();
        });
    }

    /**
     * Delete a note.
     *
     * @param Note $note
     * @return bool|null
     */
    public function delete(Note $note): ?bool
    {
        $this->deleteFile($note->image);
        return $note->delete();
    }
}
