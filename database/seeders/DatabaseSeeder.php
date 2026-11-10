<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Neema Kendi',
            'email' => 'caretaker@test.com',
            'password' => 'password123',
            'role' => 'caretaker',
        ]);

        User::create([
            'name' => 'Hezikiah Moranga',
            'email' => 'landlord@test.com',
            'password' => 'password123',
            'role' => 'landlord',
        ]);

        User::create([
            'name' => 'Maxwell Maina',
            'email' => 'tenant@test.com',
            'password' => 'password123',
            'role' => 'tenant',
        ]);
    }
}