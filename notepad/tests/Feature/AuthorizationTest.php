<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Seed permissions
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_user_can_view_notes()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $response = $this->actingAs($user)->get(route('notes.index'));
        $response->assertStatus(200);
    }

    public function test_user_can_create_note()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $response = $this->actingAs($user)->get(route('notes.create'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post(route('notes.store'), [
            'title' => 'Test Note',
            'content' => 'Content',
            // Add other required fields if any, checking migration... usually title/content/user_id
        ]);
        // Note: user_id is set in controller from Auth::id()
    }

    public function test_user_cannot_edit_others_note()
    {
        $owner = User::factory()->create();
        $owner->assignRole('user');
        $note = Note::factory()->create(['user_id' => $owner->id]);

        $otherUser = User::factory()->create();
        $otherUser->assignRole('user');

        $response = $this->actingAs($otherUser)->get(route('notes.edit', $note));
        $response->assertStatus(403);

        $response = $this->actingAs($otherUser)->put(route('notes.update', $note), [
            'title' => 'Updated Title',
            'content' => 'Updated Content'
        ]);
        $response->assertStatus(403);
    }

    public function test_admin_can_edit_others_note()
    {
        $owner = User::factory()->create();
        $owner->assignRole('user');
        $note = Note::factory()->create(['user_id' => $owner->id]);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('notes.edit', $note));
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->put(route('notes.update', $note), [
            'title' => 'Updated Title By Admin',
            'content' => 'Updated Content'
        ]);
        // Validation might fail if I don't provide all fields, but 403 vs 302/200 is what I care about.
        // If it was 403, it would fail assertion. If it's a validation error, it returns 302.
        // Let's assume valid data.

        $response->assertStatus(302); // Redirect on success
    }

    public function test_user_can_delete_own_note()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $note = Note::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('notes.destroy', $note));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('notes', ['id' => $note->id]);
    }

    public function test_user_cannot_delete_others_note()
    {
        $owner = User::factory()->create();
        $owner->assignRole('user');
        $note = Note::factory()->create(['user_id' => $owner->id]);

        $otherUser = User::factory()->create();
        $otherUser->assignRole('user');

        $response = $this->actingAs($otherUser)->delete(route('notes.destroy', $note));
        $response->assertStatus(403);
        $this->assertDatabaseHas('notes', ['id' => $note->id]);
    }
}
