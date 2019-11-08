<?php

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
        $names = [
			'Jim\'s pizza',
			'Sarah\'s cat cafe',
			'Bob\'s grill and chill',
			'RESTAURANT (tm)'
		];
		$locations = [
			'123 dover st',
			'212 kitty lane',
			'11 street road',
			'everywhere'
		];
		shuffle($names);
		shuffle($locations);
		
		for($i=0; $i < sizeof($names); ++$i)
		{
			DB::table('restaurants')->insert([
				'name' => $names[$i],
				'address' => $locations[$i],
				//TODO: Update image url once CDN is implemented
				'image' => 'my/image/url'.Str::random(10),
			]);
		}
    }
}
