<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\VehicleModel;
use App\Models\Location;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
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
            'vehiclemodel_id' => Vehiclemodel::inRandomOrder()->first()->id,
            'location_id' => Location::inRandomOrder()->first()->id,
            'version' => fake()->name(),
            'patent' => fake()->name(),
            'description' => fake()->paragraph(3),
            'km' => fake()->numberBetween(50000, 300000),
            'year' => fake()->numberBetween(1999, 2023),
            'fuel' => fake()->randomElement(['gasoil', 'gnc', 'nafta']),
            'currency' => fake()->randomElement(['$', 'u$S']),
            'price' => fake()->numberBetween(50000, 900000),
            'telephone' => fake()->numberBetween(22366224316, 2236224500),
            'comments' => fake()->paragraph(3),
            'status' => fake()->randomElement(['activo', 'inactivo']),
        ];
    }
}
