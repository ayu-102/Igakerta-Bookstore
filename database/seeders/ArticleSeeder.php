<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::truncate(); // Bersihkan data lama agar id ter-reset

        $articles = [
            [
                'title' => '5 Rekomendasi Buku Pengembangan Diri Terbaik untuk Pemula',
                'slug' => Str::slug('5 Rekomendasi Buku Pengembangan Diri Terbaik untuk Pemula'),
                'category' => 'Rekomendasi',
                'thumbnail' => null,
                'excerpt' => 'Bingung mulai dari mana untuk membangun kebiasaan baru? Simak 5 rekomendasi buku self-development yang ringan dan aplikatif.',
                'content' => '<p>Membaca buku pengembangan diri adalah salah satu langkah terbaik untuk memahami potensi diri dan memperbaiki pola pikir. Bagi kamu yang baru ingin memulai kebiasaan membaca, berikut 5 rekomendasi buku terbaik yang sangat ramah pemula...</p>',
                'author_name' => 'Tim Redaksi IGAKERTA',
                'read_time' => 4,
                'is_featured' => true,
            ],
            [
                'title' => 'Cara Konsisten Membaca 15 Menit Setiap Hari',
                'slug' => Str::slug('Cara Konsisten Membaca 15 Menit Setiap Hari'),
                'category' => 'Tips Membaca',
                'thumbnail' => null,
                'excerpt' => 'Sering merasa tidak punya waktu untuk membaca? Terapkan teknik mikro-kebiasaan ini agar membaca terasa ringan tanpa beban.',
                'content' => '<p>Banyak dari kita merasa kesulitan meluangkan waktu khusus untuk membaca buku di tengah kesibukan harian. Padahal, kuncinya bukan pada durasi yang lama, melainkan konsistensi kecil...</p>',
                'author_name' => 'Tim IGAKERTA',
                'read_time' => 3,
                'is_featured' => false,
            ],
            [
                'title' => 'Mengapa Buku Fisik Tetap Punya Tempat di Hati Pembaca?',
                'slug' => Str::slug('Mengapa Buku Fisik Tetap Punya Tempat di Hati Pembaca'),
                'category' => 'Berita',
                'thumbnail' => null,
                'excerpt' => 'Di era digital dan gempuran gadget, popularitas buku fisik ternyata tidak pernah pudar. Simak ulasan sensasi aromatik halaman buku.',
                'content' => '<p>Meskipun kemudahan ebook makin populer, buku fisik tetap memiliki tempat spesial bagi para pencinta literasi. Sensasi membalik halaman, aroma kertas, hingga estetika rak buku...</p>',
                'author_name' => 'Penulis IGAKERTA',
                'read_time' => 5,
                'is_featured' => false,
            ],
            [
                'title' => 'Wawancara Eksklusif: Rahasia Penulis Bestseller Menerbitkan Karya',
                'slug' => Str::slug('Wawancara Eksklusif Rahasia Penulis Bestseller Menerbitkan Karya'),
                'category' => 'Wawancara',
                'thumbnail' => null,
                'excerpt' => 'Mengupas proses kreatif, riset karakter, hingga mengatasi writer block langsung dari sudut pandang penulis ternama.',
                'content' => '<p>Menulis sebuah buku bukanlah perjalanan yang singkat. Kali ini tim IGAKERTA berkesempatan berbincang mengenai lika-liku proses kreatif di balik terciptanya karya bestseller...</p>',
                'author_name' => 'Redaksi Literasi',
                'read_time' => 6,
                'is_featured' => false,
            ]
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
