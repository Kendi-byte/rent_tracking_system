<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Caretaker Account
        User::create([
            'name' => 'John Caretaker',
            'email' => 'caretaker@test.com',
            'password' => Hash::make('password123'),
            'role' => 'caretaker',
        ]);

        // Landlord Account
        User::create([
            'name' => 'Alice Landlord',
            'email' => 'landlord@test.com',
            'password' => Hash::make('password123'),
            'role' => 'landlord',
        ]);

        // Tenant Account
        User::create([
            'name' => 'Bob Tenant',
            'email' => 'tenant@test.com',
            'password' => Hash::make('password123'),
            'role' => 'tenant',
        ]);
    }
}