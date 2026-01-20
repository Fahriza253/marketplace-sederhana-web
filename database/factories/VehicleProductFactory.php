<?php

namespace Database\Factories;

use App\Models\VehicleProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleProductFactory extends Factory
{
    protected $model = VehicleProduct::class;

    public function definition(): array
    {
        return [
            'brand'           => fake()->randomElement(['Toyota', 'Honda', 'Suzuki', 'Daihatsu', 'Mitsubishi']),
            'model'           => fake()->randomElement(['Avanza', 'Civic', 'Pajero', 'Rush', 'Ertiga']),
            'year'            => fake()->numberBetween(2015, 2024),
            'engine_capacity' => fake()->randomElement(['1200cc', '1500cc', '2000cc']),
            'license_plate'   => fake()->unique()->regexify('[A-Z]{1,2} [0-9]{4} [A-Z]{2}'),
        ];
    }
}
