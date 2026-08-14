<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Voucher::truncate(); // Bersihkan data lama agar ID ter-reset

        Voucher::create([
            'code'         => 'HEMAT10K',
            'title'        => 'Potongan Langsung Rp10.000',
            'description'  => 'Potongan harga Rp10.000 dengan minimal belanja Rp50.000.',
            'type'         => 'fixed',
            'amount'       => 10000,
            'min_purchase' => 50000,
            'expiry_date'  => now()->addMonths(3),
            'is_active'    => true,
        ]);
    }
}
