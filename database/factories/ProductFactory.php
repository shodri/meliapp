<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(3),
            'price' => fake()->randomFloat($maxDecimals = 2, $min = 3, $max = 100),
            'stock' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement(['available', 'unavailable']),
        ];
    }
}
