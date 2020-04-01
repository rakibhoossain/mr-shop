<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\User;
use App\Brand;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
	$price = $faker->randomFloat(2, 1, 100 );
    return [
        'name' => Str::title($faker->sentence(2)),
        'price' => ($price * 1.2),
        'purchase_price' => $price,
        'alert_quantity' => rand(3, 10),
        'description' => $faker->text,
        'user_id' => function () {
            return User::all()->random();
            // return User::where('type', 'admin')->get()->random();
        },
        'brand_id' => function () {
            return Brand::all()->random();
        },
        'quantity' => rand(0, 10)
    ];
});