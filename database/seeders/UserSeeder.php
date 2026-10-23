<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'agrobig@gmail.com'],
            [
                'name' => 'Agrobig',
                'password' => Hash::make('1507'),
                'role' => \App\Enums\UserRole::ADMIN,
                'is_active' => true,
            ]
        );
    }
}
