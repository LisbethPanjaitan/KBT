<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@kbt.com',
            'phone' => '061-4567890',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create Demo User
        User::create([
            'name' => 'Demo User',
            'email' => 'user@kbt.com',
            'phone' => '0812-3456-7890',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
    }
}
