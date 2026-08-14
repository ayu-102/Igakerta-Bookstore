<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::truncate(); // Bersihkan data lama agar ID ter-reset

        $title = '5 Rekomendasi Buku Pengembangan Diri Terbaik untuk Pemula';

        Article::create([
            'title'       => $title,
            'slug'        => Str::slug($title),
            'category'    => 'Rekomendasi',
            'thumbnail'   => 'images/artikel.jpg',
            'excerpt'     => 'Bingung mulai dari mana untuk membangun kebiasaan baru? Simak 5 rekomendasi buku self-development yang ringan dan aplikatif.',
            'content'     => '<p>Membaca buku pengembangan diri adalah salah satu langkah terbaik untuk memahami potensi diri dan memperbaiki pola pikir. Bagi kamu yang baru ingin memulai kebiasaan membaca, berikut rekomendasi buku terbaik yang sangat ramah pemula...</p>',
            'author_name' => 'Tim Redaksi IGAKERTA',
            'read_time'   => 4,
            'is_featured' => true,
        ]);
    }
}
