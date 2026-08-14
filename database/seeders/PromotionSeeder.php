<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        Promotion::truncate(); // Bersihkan data lama agar ID ter-reset ke 1

        Promotion::create([
            'name'                => 'Promo Spesial Cuci Gudang',
            'discount_percentage' => 15,
            'is_active'           => true,
            'start_date'          => now(),
            'end_date'            => now()->addDays(14),
        ]);
    }
}
