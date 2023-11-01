<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehiclemodel>
 */
class VehiclemodelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'name' => fake()->unique()->randomElement(['Model1', 'Model2', 'Model3', 'Model4' ]),

        ];
    }
}
