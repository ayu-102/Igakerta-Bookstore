<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\BookStoreSeeder;
use Illuminate\Support\Facades\DB; // <--- PENTING: Tambahkan ini

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Matikan pengecekan Foreign Key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Jalankan semua seeder kamu
        $this->call([
            AdminUserSeeder::class,
            UserSeeder::class,
            PublisherSeeder::class,
            CategorySeeder::class,
            AuthorSeeder::class,
            BookStoreSeeder::class,
            ArticleSeeder::class,
            VoucherSeeder::class,
            PromotionSeeder::class,
            TestimonialSeeder::class,
        ]);

        // 3. Nyalakan kembali pengecekan Foreign Key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
