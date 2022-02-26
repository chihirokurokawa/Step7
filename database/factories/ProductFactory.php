<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'company_id' => $faker->numberBetween,
        'product_name' => $faker->word,
        'price' => $faker->numberBetween($min = 110, $max = 150),
        'stock' => $faker->numberBetween($min = 0, $max = 50),
        'comment' => $faker->sentence,
        'img_path' => $faker->image,
       
    ];
});
