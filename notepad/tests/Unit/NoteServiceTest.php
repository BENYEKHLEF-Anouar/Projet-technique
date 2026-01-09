<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Note;
use App\Models\User;
use App\Models\Category;
use App\Services\NoteService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NoteServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_get_all_notes()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $note1 = Note::create([
            'name' => 'Note 1',
            'content' => 'Content 1',
            'user_id' => $user->id,
        ]);

        $note2 = Note::create([
            'name' => 'Note 2',
            'content' => 'Content 2',
            'user_id' => $user->id,
        ]);

        $service = new NoteService();

        $result = $service->getNotes();

        $this->assertEquals(2, $result->total());
    }

    public function test_it_can_filter_notes_by_search()
    {
        $user = User::create([
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => bcrypt('password'),
        ]);

        Note::create([
            'name' => 'Laravel Tips',
            'content' => 'Some content',
            'user_id' => $user->id,
        ]);

        Note::create([
            'name' => 'PHP Basics',
            'content' => 'Some content',
            'user_id' => $user->id,
        ]);

        $service = new NoteService();

        $result = $service->getNotes('Laravel');

        $this->assertEquals(1, $result->total()); // Only 1 matching record
        $this->assertEquals('Laravel Tips', $result->first()->name); // checks that the expected value equals the actual value
    }

    public function test_it_can_create_a_note_with_categories()
    {
        $user = User::create([
            'name' => 'Bob',
            'email' => 'bob@example.com',
            'password' => bcrypt('password'),
        ]);

        $category1 = Category::create([
            'name' => 'Tech',
            'description' => 'Tech stuff',
        ]);

        $category2 = Category::create([
            'name' => 'Education',
            'description' => 'Learning',
        ]);

        $service = new NoteService();

        $data = [
            'name' => 'New Note',
            'content' => 'Some content',
            'user_id' => $user->id,
            'category_ids' => [$category1->id, $category2->id],
        ];

        $note = $service->createNote($data);

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'name' => 'New Note',
            'user_id' => $user->id,
        ]);

        $this->assertCount(2, $note->categories);
    }

    public function test_it_can_update_a_note()
    {
        $user = User::create([
            'name' => 'Charlie',
            'email' => 'charlie@example.com',
            'password' => bcrypt('password'),
        ]);

        $note = Note::create([
            'name' => 'Old Note',
            'content' => 'Old content',
            'user_id' => $user->id,
        ]);

        $service = new NoteService();

        $updated = $service->updateNote($note->id, [
            'name' => 'Updated Note',
            'content' => 'Updated content',
        ]);

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'name' => 'Updated Note',
            'content' => 'Updated content',
        ]);
    }

    public function test_it_can_delete_a_note()
    {
        $user = User::create([
            'name' => 'Dana',
            'email' => 'dana@example.com',
            'password' => bcrypt('password'),
        ]);

        $note = Note::create([
            'name' => 'Delete Me',
            'content' => 'Content',
            'user_id' => $user->id,
        ]);

        $service = new NoteService();

        $service->deleteNote($note->id);

        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
        ]);
    }
}
