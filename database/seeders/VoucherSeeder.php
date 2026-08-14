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
        Voucher::truncate();

        Voucher::create([
            'code' => 'HEMAT10K',
            'title' => 'Potongan Langsung Rp10.000',
            'description' => 'Potongan harga Rp10.000 dengan minimal belanja Rp50.000.',
            'type' => 'fixed',
            'amount' => 10000,
            'min_purchase' => 50000,
            'expiry_date' => now()->addMonths(3),
            'is_active' => true,
        ]);

        Voucher::create([
            'code' => 'IGAKERTA15',
            'title' => 'Diskon Spesial 15%',
            'description' => 'Diskon 15% untuk semua kategori buku dengan minimal belanja Rp100.000.',
            'type' => 'percentage',
            'amount' => 15,
            'min_purchase' => 100000,
            'expiry_date' => now()->addMonths(1),
            'is_active' => true,
        ]);

        Voucher::create([
            'code' => 'GATOTKACA',
            'title' => 'Promo Pengguna Baru',
            'description' => 'Potongan harga Rp20.000 khusus untuk pembelian pertama.',
            'type' => 'fixed',
            'amount' => 20000,
            'min_purchase' => 75000,
            'expiry_date' => now()->addMonths(6),
            'is_active' => true,
        ]);
    }
}
