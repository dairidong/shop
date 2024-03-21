<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeGroup;
use App\Models\ProductSku;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::factory()
            ->count(10)
            ->has(
                ProductAttributeGroup::factory()
                    ->count(fake()->numberBetween(1, 3))
                    ->has(
                        ProductAttribute::factory()
                            ->count(fake()->numberBetween(1, 5)), 'attributes'),
                'attribute_groups'
            )->create();

        foreach ($products as $product) {
            ProductSku::factory()
                ->for($product)
                ->state(function () use ($product) {
                    $skuAttributes = $product->attribute_groups->map(function (ProductAttributeGroup $group) {
                        return $group->attributes->random()->only(['id', 'value', 'product_attribute_group_id']);
                    });

                    return [
                        'attributes' => $skuAttributes,
                    ];
                })->count($product->attribute_groups->count())->create();
        }
    }
}
