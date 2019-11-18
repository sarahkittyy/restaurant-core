<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Restaurant;
use Faker\Generator as Faker;

$factory->define(Restaurant::class, function (Faker $faker) {
    return [
		'name' => $faker->month.' '.$faker->name.' restaurant',
		'address' => $faker->address,
		'image' => '/cdn/default256x256.png',
    ];
});
