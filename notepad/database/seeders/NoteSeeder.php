<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;
use App\Models\Category;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        if (($handle = fopen(database_path('data/notes.csv'), 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);

                $note = Note::create([
                    'name' => $data['name'],
                    'content' => $data['content'],
                    'image' => $data['image'],
                ]);

                // Attach categories
                $categories = explode('|', $data['categories']); // Splits the categories string by | : 'Work|Project X'
                $categoryIds = Category::whereIn('name', $categories)->pluck('id'); // Gets the IDs of categories that match the names in the array.
                // $note->categories()->attach($categoryIds); //Uses a many-to-many relationship to attach categories to the note.
                $note->categories()->sync($categoryIds); //Uses a many-to-many relationship to sync categories to the note (preventing duplicates).
            }
            fclose($handle);
        }
    }
}
