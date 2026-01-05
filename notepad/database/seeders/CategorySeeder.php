<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        if (($handle = fopen(database_path('data/categories.csv'), 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);
                Category::create([
                    'name' => $data['name'],
                    'description' => $data['description'],
                ]);
            }
            fclose($handle);
        }
    }
}
