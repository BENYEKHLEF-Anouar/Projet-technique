<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Note;
use App\Models\Category;
use App\Models\User;
use App\Services\NoteService;
use Illuminate\Foundation\Testing\RefreshDatabase; // 1. Switched Trait

class NoteServiceTest extends TestCase
{
    // 2. Use RefreshDatabase to wipe the DB clean before every single test
    use RefreshDatabase;

    protected NoteService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new NoteService();
    }

    public function test_it_can_get_all_notes()
    {
        // Arrange: Create exactly 3 notes using a Factory
        Note::factory()->count(3)->create();

        // Act
        $result = $this->service->getAll();

        // Assert: We know exactly how many should exist
        $this->assertEquals(3, $result->total());
    }

    public function test_it_can_filter_notes_by_search()
    {
        // Arrange: Create one note with 'Laravel' and one without
        Note::factory()->create(['content' => 'I love learning Laravel']);
        Note::factory()->create(['content' => 'I love learning PHP']);

        // Act
        $result = $this->service->getAll(['search' => 'Laravel']);

        // Assert
        $this->assertEquals(1, $result->total());
        $this->assertStringContainsString('Laravel', collect($result->items())->first()->content);
    }

    public function test_it_can_filter_notes_by_category()
    {
        // Arrange: Create a category and a note, and link them
        $category = Category::factory()->create(['name' => 'Éducation']);
        $note = Note::factory()->create();
        $note->categories()->attach($category->id);

        // Act
        $result = $this->service->getAll(['category_id' => $category->id]);

        // Assert
        $this->assertEquals(1, $result->total());
        
        foreach ($result->items() as $returnedNote) {
            $noteCategories = $returnedNote->categories->pluck('id')->toArray();
            $this->assertContains($category->id, $noteCategories);
        }
    }

    public function test_it_can_create_a_note_with_categories()
    {
        // Arrange: Create fresh user and categories
        $categories = Category::factory()->count(2)->create();
        $user = User::factory()->create();

        $data = [
            'name' => 'New Note Test',
            'content' => 'Some content',
            'user_id' => $user->id,
            'category_ids' => $categories->pluck('id')->toArray(),
        ];

        // Act
        $note = $this->service->create($data);

        // Assert
        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'name' => 'New Note Test',
        ]);
        $this->assertCount(2, $note->categories);
    }

    public function test_it_can_update_a_note()
    {
        // Arrange: Create a fresh note
        $note = Note::factory()->create(['name' => 'Old Name']);

        $updatedData = [
            'name' => 'Updated Note Test',
            'content' => 'Updated content',
        ];

        // Act
        $this->service->update($note, $updatedData);

        // Assert
        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'name' => 'Updated Note Test',
            'content' => 'Updated content',
        ]);
    }

    public function test_it_can_delete_a_note()
    {
        // Arrange: Create a fresh note
        $note = Note::factory()->create();

        // Act
        $this->service->delete($note);

        // Assert
        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
        ]);
    }
}