<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->randomElement(['CASA CENTRAL', 'DEPOSITO', 'TALLER' ]),
            'address' => fake()->sentence(3),
            'province' => fake()->randomElement(['Bs As', 'La Rioja', 'Córdoba', 'Santa Fe' ]),
            'city' => fake()->randomElement(['CABA', 'La Plata', 'Mar del Plata', 'Rosario' ]),
            'coordinates' => fake()->numberBetween(2, 100000),
            'telephone' => fake()->numberBetween(5, 15000000),

        ];
    }
}
