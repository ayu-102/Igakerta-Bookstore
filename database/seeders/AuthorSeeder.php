<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::truncate(); // Bersihkan data lama agar ID ter-reset ke 1

        Author::create([
            'name'        => 'Tere liye.',
            'title'       => 'Dosen',
            'photo'       => 'images/author.jpeg',
            'bio'         => 'Penulis aktif buku',
            'is_featured' => true,
        ]);
    }
}
