<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;
use App\Models\User;
use App\Models\Category;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        if (($handle = fopen(database_path('data/notes.csv'), 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);

                // Find the user by email
                $user = User::where('email', $data['user_email'])->first();
                if (!$user)
                    continue;

                $note = Note::create([
                    'name' => $data['name'],
                    'content' => $data['content'],
                    'image' => $data['image'],
                    'user_id' => $user->id,
                ]);

                // Attach categories
                $categories = explode('|', $data['categories']);
                $categoryIds = Category::whereIn('name', $categories)->pluck('id');
                $note->categories()->attach($categoryIds);
            }
            fclose($handle);
        }
    }
}
