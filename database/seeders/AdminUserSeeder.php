<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Buat user admin default
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@kbt.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Operator Loket',
            'email' => 'operator@kbt.com',
            'password' => Hash::make('operator123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager@kbt.com',
            'password' => Hash::make('manager123'),
            'email_verified_at' => now(),
        ]);
    }
}
