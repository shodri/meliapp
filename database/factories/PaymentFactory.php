<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'amount' => fake()->randomFloat($maxDecimals = 2, $min = 15, $max = 500),
            'payed_at' => fake()->dateTimeBetween($startDate = '-1 year', $endDate = 'now', $timezone = null),
            
        ];
    }
}
