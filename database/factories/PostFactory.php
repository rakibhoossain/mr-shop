<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\Admin;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'name' => Str::title($faker->sentence(2)),
        'description' => $faker->text,
        'admin_id' => function () {
            return Admin::all()->random();
        },
        // 'image' => $faker->image('storage/products/',640,480, null, false),
        'image' => 'storage/products/'.rand(1, 10).'.png'

    ];
});