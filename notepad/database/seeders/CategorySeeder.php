<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void // Laravel calls this method when running the seeder. void indicates it does not return any value.
    {
        if (($handle = fopen(database_path('data/categories.csv'), 'r')) !== false) { // $handle is a pointer to the file, used for reading lines.
            $header = fgetcsv($handle); // Reads the first line of the CSV (column names) into an array, e.g. ['name', 'description']
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row); // maps column names to values: ['name' => 'Work', 'description' => 'Work-related notes']
                Category::create([
                    'name' => $data['name'],
                    'description' => $data['description'],
                ]);
            }
            fclose($handle); // Frees system resources by closing the CSV file.
        }
    }
}
