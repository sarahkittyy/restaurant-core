<?php

use App\Restaurant;
use App\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RestaurantSeeder extends Seeder
{
    /**
     * Seeds the restaurant database with some sample restaurants
     *
     * @return void
     */
    public function run()
    {
		factory(Restaurant::class, 5)->create()->each(function ($restaurant) {
			$restaurant->reviews()->save(factory(Review::class)->make());
			$restaurant->reviews()->save(factory(Review::class)->make());
			$restaurant->reviews()->save(factory(Review::class)->make());
		});
    }
}
