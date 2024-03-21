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
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'long_title' => fake()->sentence,
            'product_no' => fake()->ean13(),
            'description' => fake()->text,
            'on_sale' => true,
            'extra' => [],
        ];
    }
}
