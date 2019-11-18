<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Review;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
		'title' => $faker->text(8),
		'body' => $faker->realText(200),
		'rating' => $faker->numberBetween(1,10),
    ];
});
