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
            'name' => fake()->text(50),
            'description' => fake()->text(),
            'price_including_tax' => fake()->numberBetween(1, 100000),
            'released_at' => fake()->date(),
            'brand_id' => fake()->numberBetween(1, 19),
            'category_id' => fake()->numberBetween(1, 6),
            'user_id' => 1
        ];
    }
}
