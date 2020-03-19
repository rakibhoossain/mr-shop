<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'name' => Str::title($faker->sentence(2)),
        'description' => $faker->text,
        'user_id' => function () {
            return User::all()->random();
        },
        'image' => 'storage/products/'.rand(1, 10).'.png'
    ];
});