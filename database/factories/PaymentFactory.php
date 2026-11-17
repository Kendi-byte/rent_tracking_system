<?php

namespace Database\Factories;

use App\Models\Tenancy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenancy_id'      => Tenancy::factory(),
            'amount'          => fake()->randomElement([2000, 3000, 5000, 7500]),
            'month_paid_for'  => now()->format('Y-m'),
            'mpesa_reference' => 'SH' . strtoupper(Str::random(8)),
            'status'          => 'pending',
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
        ]);
    }
}