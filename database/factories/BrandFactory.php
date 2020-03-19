<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use App\User;
use Faker\Generator as Faker;

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->catchPhrase,
        'image' => 'storage/brands/'.rand(1, 5).'.svg'
    ];
});