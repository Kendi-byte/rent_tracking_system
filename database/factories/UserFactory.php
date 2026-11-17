<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name'           => fake()->name(),
            'email'          => fake()->unique()->safeEmail(),
            'password'       => static::$password ??= Hash::make('password'),
            'role'           => 'tenant',
            'remember_token' => Str::random(10),
        ];
    }

    public function caretaker(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'caretaker',
        ]);
    }

    public function landlord(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'landlord',
        ]);
    }
}