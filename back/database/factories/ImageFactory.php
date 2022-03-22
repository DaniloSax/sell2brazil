<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $filePrefixNames = [...Product::PRODUCTS_FACTORY];
        $index = rand(0, count(Product::PRODUCTS_FACTORY) - 1);
        $product = Product::PRODUCTS_FACTORY[$index];

        return [
            'file_name' => strtolower($product['name']) . '.jpeg',
            'path' => $product['image'],
            'size' => $this->faker->randomNumber(3)
        ];
    }
}
