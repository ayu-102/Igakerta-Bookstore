<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        Testimonial::truncate(); // Bersihkan data lama agar ID ter-reset ke 1

        Testimonial::create([
            'name'      => 'Budi Santoso',
            'role'      => 'Mahasiswa / Pembeli',
            'avatar'    => null,
            'quote'     => 'Buku-buku di IGAKERTA sangat lengkap dan proses pengiriman sangat cepat!',
            'rating'    => 5,
            'is_active' => true,
        ]);
    }
}
