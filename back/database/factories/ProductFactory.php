<?php

namespace Database\Factories;

use App\Models\Product;
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
        $article_code = date('dmY') . "-" . $this->faker->randomNumber(5);

        $index = rand(0, count(Product::PRODUCTS_FACTORY) - 1);
        $product = Product::PRODUCTS_FACTORY[$index];

        return [
            'article_code' => $product['article_code'],
            'article_name' => $product['name'],
            'article_description' => $product['article_description'],
            'unit_price' => $product['price'],
        ];
    }
}
