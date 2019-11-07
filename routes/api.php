<?php

use App\Restaurant;
use Illuminate\Http\Request;

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
 * @brief Upload endpoint for posting a new restaurant listing
 * 
 * POST PARAMS:
 * - name -> string > len 3
 * - address & image url
 */
Route::post('/restaurants', function (Request $request) {
	/**
	 * name -> required, len > 3
	 * address -> required
	 * image -> required
	 */
	$validator = Validator::make($request->all(), [
		'name' => 'required|min:3',
		'address' => 'required',
		'image' => 'required'
	]);

	if ($validator->fails()) {
		return redirect()
			->route('/failure', ['msg' => 'Failed to upload new restaurant.'])
			->withErrors($validator);
	}
	
	// Creates and saves the restaurant model.
	$restaurant = new Restaurant;
	$restaurant->name = $request->name;
	$restaurant->address = $request->address;
	$restaurant->image = $request->image;
	$restaurant->save();
	
	return response('Success!');
});

/**
 * @brief Will retrieve a list of all restaurants in the database.
 * 
 * TODO: url parameters for sorting the output
 */
Route::get("/restaurants", function (Request $request) {
	return '404';
});
