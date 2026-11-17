<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenancy>
 */
class TenancyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'unit_label'   => fake()->randomElement(['A', 'B', 'C']) . fake()->unique()->numberBetween(101, 410),
            'monthly_rent' => fake()->randomElement([12000, 15000, 18000, 22000, 25000]),
        ];
    }
}