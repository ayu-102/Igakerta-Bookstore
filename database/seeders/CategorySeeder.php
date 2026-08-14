<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::truncate(); // Bersihkan data lama agar ID ter-reset ke 1

        $name = 'Fiksi Sastra';

        Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
        ]);
    }
}
