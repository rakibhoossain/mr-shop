<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductTag;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ProductTag::class, function (Faker $faker) {
    return [
        'name' => Str::title($faker->word)
    ];
});
