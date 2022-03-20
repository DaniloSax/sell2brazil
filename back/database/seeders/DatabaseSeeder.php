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
        ])->has(Image::factory(3), 'images')->count(5)->create();

        Order::factory()
            ->count(3)
            ->state([
                'created_by' => $user->id,
                'updated_by' => $user->id
            ])
            ->hasAttached(
                $products,
                fn () => [
                    'user_id' => User::all()->random()->first()->id
                ],
            )
            ->create();
    }
}
