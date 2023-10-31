<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        $users = \App\Models\User::factory(20)
            ->create()
            ->each(function($user) {
                $image = \App\Models\Image::factory()
                    ->user()
                    ->make();

                $user->image()->save($image);
            });

        $orders = \App\Models\Order::factory(10)
            ->make()
            ->each(function($order) use ($users) {
                $order->customer_id = $users->random()->id;
                $order->save();

                $payment = \App\Models\Payment::factory()->make();

                // $payment->order_id = $order->id;
                // $payment->save();

                $order->payment()->save($payment);
            });

        $carts = \App\Models\Cart::factory(20)->create();


        $products = \App\Models\Product::factory(50)
            ->create()
            ->each(function ($product) use ($orders, $carts) {
                $order = $orders->random();

                $order->products()->attach([
                    $product->id => ['quantity' => mt_rand(1, 3)]
                ]);

                $cart = $carts->random();

                $cart->products()->attach([
                    $product->id => ['quantity' => mt_rand(1, 3)]
                ]);

                $images = \App\Models\Image::factory(mt_rand(2, 4))->make();
                $product->images()->saveMany($images);

            });


            $brands = \App\Models\Brand::factory(4)
            ->create();

            $models = \App\Models\Vehiclemodel::factory(4)
            ->create();

            $locations = \App\Models\Location::factory(8)
            ->create();

            $vehicles = \App\Models\Vehicle::factory(50)
            ->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
