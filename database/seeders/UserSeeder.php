<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Mencari atau membuat akun customer demo
        User::updateOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name'     => 'Demo Customer',
                'role'     => 'customer',
                'phone'    => '089876543210',
                'points'   => 0,
                'password' => Hash::make('password123'),
            ]
        );
    }
}
