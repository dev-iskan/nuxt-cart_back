<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $name =$faker->unique()->name,
        'slug' => str_slug($name),
        'description' => $faker->sentence(5),
        'price' => 1000
    ];
});
