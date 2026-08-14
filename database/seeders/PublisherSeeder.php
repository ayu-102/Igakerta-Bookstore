<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;

class PublisherSeeder extends Seeder
{
    public function run(): void
    {
        Publisher::truncate(); // Bersihkan data lama agar ID ter-reset ke 1

        Publisher::create([
            'name'    => ' PT Gramedia Pustaka Utama',
            'address' => 'Jl. Edukasi No. 123, Jakarta Selatan',
            'phone'   => '021-5551234',
        ]);
    }
}
