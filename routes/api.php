<?php

use App\Restaurant;
use Illuminate\Http\Request;

include('post.php');

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
