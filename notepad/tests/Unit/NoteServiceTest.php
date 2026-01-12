<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Note;
use App\Models\Category;
use App\Models\User;
use App\Services\NoteService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NoteServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected NoteService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new NoteService();
    }

    public function test_it_can_get_all_notes()
    {
        $result = $this->service->getNotes();
        $this->assertGreaterThan(0, $result->total());
    }

    public function test_it_can_filter_notes_by_search()
    {
        $result = $this->service->getNotes('Laravel');

        $this->assertEquals(1, $result->total());

        $firstNote = collect($result->items())->first();
        $this->assertStringContainsString('Laravel', $firstNote->content);
    }

    public function test_it_can_filter_notes_by_category()
    {
        // Pick a category that exists in your seeded data
        $category = Category::where('name', 'Éducation')->first();

        $result = $this->service->getNotes(null, $category->id);

        $this->assertGreaterThan(0, $result->total());

        // Ensure every returned note belongs to the selected category
        foreach ($result->items() as $note) { // Loops through all returned notes and checks each note belongs to that category.
            $noteCategories = $note->categories->pluck('id')->toArray();
            $this->assertContains($category->id, $noteCategories);
        }
    }

    public function test_it_can_create_a_note_with_categories()
    {
        $categories = Category::take(2)->get();
        $user = User::first();

        $data = [
            'name' => 'New Note Test',
            'content' => 'Some content',
            'user_id' => $user->id,
            'category_ids' => $categories->pluck('id')->toArray(),
        ];

        $note = $this->service->createNote($data);

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'name' => 'New Note Test',
        ]);

        $this->assertCount(2, $note->categories);
    }

    public function test_it_can_update_a_note()
    {
        $note = Note::first();

        $updatedData = [
            'name' => 'Updated Note Test',
            'content' => 'Updated content',
        ];

        $this->service->updateNote($note->id, $updatedData);

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'name' => 'Updated Note Test',
            'content' => 'Updated content',
        ]);
    }

    public function test_it_can_delete_a_note()
    {
        $note = Note::first();

        $this->service->deleteNote($note->id);

        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
        ]);
    }
}
