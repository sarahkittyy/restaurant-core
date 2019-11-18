<?php

use Illuminate\Http\Request;
use App\Restaurant;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	$restaurants = Restaurant::all();
    return view('home', ['restaurants' => $restaurants]);
});

/**
 * @brief Displays a page focused on the specific restaurant at hand
 */
Route::get('/restaurant', function (Request $request) {
	$restaurantName = $request->input('restaurant');
	$restaurant = Restaurant::where('name', $restaurantName)->first();
	return view('restaurant', ['restaurant' => $restaurant]);
});

/**
 * @brief Routes to the restaurant / review routes
 */
Route::prefix('/new')->group(function () {
	Route::get('/restaurant', function () {
		return view('post-restaurant');
	});
	Route::get('/review', function (Request $request) {
		return view('post-review', [ 'restaurant' => $request->restaurant ]);
	});
});

/**
 * Generic success page.
 */
Route::get('/success', function (Request $request) {
	return view('success', ['msg' => $request->input('msg')]);
});

/**
 * Generic failure page
 */
Route::get('/failure', function (Request $request) {
	return view('failure', ['msg' => $request->input('msg')]);
});

/**
 * @brief Retrieve a file saved in public storage.
 */
Route::get('/cdn/{file}', function ($file) {
	return response(Storage::disk('public')->get($file))
			->header('Content-Type', 'image');
});