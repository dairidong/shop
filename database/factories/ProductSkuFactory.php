<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductSku>
 */
class ProductSkuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bar_no' => fake()->ean13(),
            'stock' => fake()->randomNumber(),
            'price' => fake()->randomFloat(2, 0.01, 9999),
            'compare_at_price' => fake()->randomFloat(2, 0.01, 9999),
            'cost' => fake()->randomFloat(2, 0.01, 9999),
            'attributes' => '',
            'product_id' => Product::factory(),
            'on_sale' => true,
        ];
    }
}
