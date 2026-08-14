<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Testimonial;

class BookStoreSeeder extends Seeder
{
    public function run(): void
    {
        // Data Dummy Penulis Pilihan
        Author::create([
            'name' => 'Dr. Ahmad Fauzi, M.T.',
            'title' => 'Dosen & Peneliti Teknik',
            'photo' => null, // Bisa diisi URL/Path gambar nantinya
            'bio' => 'Penulis aktif buku-buku rekayasa teknologi dan sains terapan.',
            'is_featured' => true,
        ]);

        Author::create([
            'name' => 'Prof. Siti Rahmawati',
            'title' => 'Guru Besar Pendidikan',
            'photo' => null,
            'bio' => 'Fokus pada riset kurikulum dan metode pembelajaran modern.',
            'is_featured' => true,
        ]);

        // Data Dummy Kata Pembaca
        Testimonial::create([
            'name' => 'Budi Santoso',
            'role' => 'Mahasiswa Teknik',
            'avatar' => null,
            'quote' => 'Buku-buku akademik di sini sangat lengkap dan proses pengiriman cepat!',
            'rating' => 5,
            'is_active' => true,
        ]);

        Testimonial::create([
            'name' => 'Dewi Lestari',
            'role' => 'Dosen / Peneliti',
            'avatar' => null,
            'quote' => 'Sangat membantu dalam mencari literatur penelitian berkualitas tinggi.',
            'rating' => 5,
            'is_active' => true,
        ]);
    }
}
