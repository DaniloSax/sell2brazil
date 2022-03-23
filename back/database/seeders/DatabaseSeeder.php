<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
        ]);

        User::factory(20)->create();

        $user = User::all()->random()->first();

        $products = Product::factory()->state([
            'created_by' => $user->id,
            'updated_by' => $user->id
        ])->count(20)
            ->create();

        foreach ($products as $prod) {

            $factoryProd = collect(Product::PRODUCTS_FACTORY)->where('article_code', $prod->article_code)->first();

            $prod->images()->create([
                'file_name' => strtolower($factoryProd['name']) . '.jpeg',
                'path' => $factoryProd['image'],
                'size' => rand(10, 50)
            ]);
        }

        Order::factory()
            ->count(3)
            ->state([
                'created_by' => $user->id,
                'updated_by' => $user->id
            ])
            ->hasAttached(
                $products,
                fn () => [
                    'user_id' => User::all()->random()->first()->id,
                ],
            )
            ->create();
    }
}
