<?php

use App\Restaurant;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

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
 */
Route::get("/restaurants", function (Request $request) {
	$restaurants = Restaurant::all();
	
	// Check for sorting query
	$sortBy = $request->sortBy;
	$desc = $request->descend == '1';
	$sorted = null;
	if(!is_null($sortBy))
	{
		// Exceptional case if we want to sort by reviews, because otherwise we can just
		// use sortBy normally
		if($sortBy == 'rating')
		{
			$sorted = $restaurants->sortBy(function ($restaurant, $key) {
				$request = Request::create(route('api.averageReview'), 'GET', [
					'restaurant' => $restaurant->name,
				], [], [], $_SERVER);
				$response = app()->handle($request);
				$responseBody = json_decode($response->getContent(), true);
				return (float)$responseBody['response'];
			});
		}
		else
		{
			$sorted = $restaurants->sortBy($sortBy, SORT_REGULAR, $desc);
		}
	}
	else
	{
		$sorted = $restaurants;
	}
	
	return response()->json([
		'success' => true,
		'restaurants' => $sorted,
	]);
});

/**
 * @brief Retrieves a list of all reviews in the database.
 * 
 */

Route::get('/reviews', function (Request $request) {
	$reviews = Review::all();
	
	// Optional name of the restaurant to get the reviews for
	$restaurant_name = $request->restaurant;
	
	// If none was specified, just return all reviews.
	if(is_null($restaurant_name))
	{
		return response()->json([
			'success' => true,
			'reviews' => $reviews,
		]);
	}
	else
	{
		// Try getting the restaurant with the given restaurant name
		$restaurant = Restaurant::all()->where('name', '=', $restaurant_name)->first();
		// If that's not found..
		if(is_null($restaurant))
		{
			// Failure response
			return response()->json([
				'success' => false,
				'response' => $restaurant_name.' not found.',
			]);
		}
		else
		{
			// Otherwise, return all reviews for that restaurant.
			return response()->json([
				'success' => true,
				'reviews' => $restaurant->reviews,
			]);
		}
	}
});

/**
 * @brief Gets the average review rating of a restaurant.
 */
Route::get('/averageReview', function (Request $request) {
	/**
	 * restaurant -> required, name of restaurant to calculate review rating for.
	 */
	$validator = Validator::make($request->all(), [
		'restaurant' => 'required'
	]);
	
	if($validator->fails())
	{
		return response()->json([
			'success' => false,
			'response' => 'Restaurant name must be provided.'
		],400);
	}
	
	// Get & validate the restaurant
	$restaurant = Restaurant::all()->where('name', '=', $request->restaurant)->first();
	if(is_null($restaurant))
	{
		return response()->json([
			'success' => false,
			'response' => 'Restaurant '.$request->restaurant.' not found.'
		], 400);
	}
	
	// Get all reviews of the restaurant
	$reviews = $restaurant->reviews;
	$sum = 0;
	$count = $reviews->count();
	foreach ($reviews as $review)
	{
		$sum += $review->rating;
	}
	
	return response()->json([
		'success' => true,
		'response' => round($sum / $count, 2),
	], 200);
})->name('api.averageReview');