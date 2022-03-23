<?php

namespace Database\Factories;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'order_code' => ,
            'order_date' => $this->faker->date('Y-m-d'),
            'total_amount_wihtout_discount' => $this->faker->randomFloat(2, 100, 500),
            'total_amount_with_discount' => $this->faker->randomFloat(2, 10, 150),
            'finished' => (bool) rand(0, 1),
        ];
    }
}
