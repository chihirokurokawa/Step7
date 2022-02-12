<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sale;
use Faker\Generator as Faker;

$factory->define(Sale::class, function (Faker $faker) {
    return [
        'product_id' => $faker ->id,
        'created_at' => $faker->datetime($max = 'now', $timezone = date_default_timezone_get()),

    ];
});
