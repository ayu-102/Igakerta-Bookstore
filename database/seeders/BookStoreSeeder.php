<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use Illuminate\Support\Str;

class BookStoreSeeder extends Seeder
{
    public function run(): void
    {
        Book::truncate(); // Bersihkan data buku lama agar ID ter-reset

        $title = 'Bumi';

        Book::create([
            // Kolom Relasi (Pastikan seeder Category, Author, dan Publisher dijalankan lebih dulu agar ID 1 tersedia)
            'category_id'      => 1,
            'author_id'        => 1,
            'publisher_id'     => 1,

            // Komponen Data Buku
            'title'            => $title,
            'slug'             => Str::slug($title),
            'isbn'             => '978-623-0000-00-1',
            'publication_year' => '2026',
            'pages'            => 250,
            'dimensions'       => '14 x 21 cm',
            'weight'           => 300, // Misal dalam gram
            'language'         => 'Bahasa Indonesia',
            'cover_type'       => 'Soft Cover',
            'type'             => 'physical', // Sesuaikan jika kamu pakai enum seperti 'physical'/'digital'
            'file_pdf'         => null,
            'price'            => 75000,
            'stock'            => 15,
            'discount_price'   => null, // Harga coret (opsional)
            'cover_image'      => 'images/cover-1.jpeg',
            'description'      => 'mengisahkan petualangan tiga remaja usia 15 tahun bernama Raib, Seli, dan Ali yang menjelajahi dunia paralel di luar bumi tempat manusia tinggal',
            'is_featured'      => true,
        ]);
    }
}
