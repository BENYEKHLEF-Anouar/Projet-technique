<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed the database with all data
        $this->seed();
    }

    public function test_user_can_view_notes()
    {
        // Get a regular user from seeded data
        $user = User::where('email', '!=', 'admin@example.com')->first();

        $response = $this->actingAs($user)->get(route('notes.index'));
        $response->assertStatus(200);
    }

    public function test_user_can_create_note()
    {
        // Get a regular user from seeded data
        $user = User::where('email', '!=', 'admin@example.com')->first();

        $response = $this->actingAs($user)->post(route('notes.store'), [
            'name' => 'Test Note',
            'content' => 'Test Content',
            'category_ids' => [],
        ]);

        $response->assertRedirect(route('notes.index'));
        $this->assertDatabaseHas('notes', ['name' => 'Test Note']);
    }

    public function test_user_cannot_edit_others_note()
    {
        // Get two different users
        $users = User::where('email', '!=', 'admin@example.com')->limit(2)->get();
        $owner = $users[0];
        $otherUser = $users[1];

        // Get a note owned by the first user
        $note = $owner->notes()->first();

        if (!$note) {
            $this->markTestSkipped('No notes found for owner');
        }

        $response = $this->actingAs($otherUser)->put(route('notes.update', $note), [
            'name' => 'Updated Title',
            'content' => 'Updated Content',
            'category_ids' => $note->categories->pluck('id')->toArray(),
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_edit_others_note()
    {
        // Get admin user
        $admin = User::where('email', 'admin@example.com')->first();

        // Get any note not owned by admin
        $note = Note::where('user_id', '!=', $admin->id)->first();

        if (!$note) {
            $this->markTestSkipped('No notes found for non-admin users');
        }

        $response = $this->actingAs($admin)->put(route('notes.update', $note), [
            'name' => 'Updated by Admin',
            'content' => 'Admin Content',
            'category_ids' => $note->categories->pluck('id')->toArray(),
        ]);

        $response->assertRedirect(route('notes.index'));
        $this->assertDatabaseHas('notes', ['name' => 'Updated by Admin']);
    }

    public function test_user_can_delete_own_note()
    {
        // Get a regular user
        $user = User::where('email', '!=', 'admin@example.com')->first();

        // Get one of their notes
        $note = $user->notes()->first();

        if (!$note) {
            $this->markTestSkipped('No notes found for user');
        }

        $noteId = $note->id;

        $response = $this->actingAs($user)->delete(route('notes.destroy', $note));
        $response->assertRedirect(route('notes.index'));
        $this->assertDatabaseMissing('notes', ['id' => $noteId]);
    }

    public function test_user_cannot_delete_others_note()
    {
        // Get two different users
        $users = User::where('email', '!=', 'admin@example.com')->limit(2)->get();
        $owner = $users[0];
        $otherUser = $users[1];

        // Get a note owned by the first user
        $note = $owner->notes()->first();

        if (!$note) {
            $this->markTestSkipped('No notes found for owner');
        }

        $noteId = $note->id;

        $response = $this->actingAs($otherUser)->delete(route('notes.destroy', $note));
        $response->assertStatus(403);
        $this->assertDatabaseHas('notes', ['id' => $noteId]);
    }
}
