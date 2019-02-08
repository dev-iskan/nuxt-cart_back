<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Stock::class, function (Faker $faker) {
    return [
        'quantity' => 1
    ];
});
