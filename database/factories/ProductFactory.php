<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'company_id' => $faker->id,
        'product_name' => $faker->product_name,
        'price' => $faker->price,
        'stock' => $faker->numberBetween($min = 0, $max = 50),
        'comment' => $faker->sentence,
        'img_path' => $faker->image,
        'created_at' => $faker->datetime($max = 'now', $timezone = date_default_timezone_get()),
    ];
});
