<?php

use App\Restaurant;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

include_once('post.php');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get("/", function (Request $request) {
	return view('api-home');
});

/**
 * @brief 
 * 
 * ENDPOINTS
 * - /post/restaurant -> upload a new restaurant
 * - /post/review -> upload a new review
 * 
 */
Route::prefix('/post')->group(function() { posts(); });

/**
 * @brief Retrieves a list of all restaurants in the database.
 * 
 * TODO: url parameters for sorting the output
 */
Route::get("/restaurants", function (Request $request) {
	$restaurants = Restaurant::all();
	
	return response()->json([
		'success' => true,
		'restaurants' => $restaurants
	]);
});

/**
 * @brief Retrieves a list of all reviews in the database.
 */

Route::get('/reviews', function (Request $request) {
	$reviews = Review::all();
	
	$restaurant_name = $request->restaurant;
	
	if(is_null($restaurant_name))
	{
		return response()->json([
			'success' => true,
			'reviews' => $reviews,
		]);
	}
	else
	{
		$restaurant = Restaurant::all()->where('name', '=', $restaurant_name)->first();
		if(is_null($restaurant))
		{
			return response()->json([
				'success' => false,
				'response' => $restaurant_name.' not found.',
			]);
		}
		else
		{
			return response()->json([
				'success' => true,
				'reviews' => $restaurant->reviews,
			]);
		}
	}
});