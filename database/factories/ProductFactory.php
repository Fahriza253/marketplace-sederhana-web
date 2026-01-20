<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'user_id'     => User::inRandomOrder()->value('id'),
            'category_id' => Category::inRandomOrder()->value('id'),
            'name'        => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'price'       => fake()->numberBetween(80_000_000, 600_000_000),
            'stock'       => 1,
            'status'      => 'available',
            'condition'   => fake()->randomElement(['new', 'used']),
            'sold_at'     => null,
        ];
    }
}
