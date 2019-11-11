<?php

use Illuminate\Http\Request;
use App\Restaurant;

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
	$restaurant = $request->input('restaurant');
	return 'hewwo, '.$restaurant;
});

/**
 * @brief Routes to the new restaurant route.
 */
Route::get('/new', function () {
	return view('post-restaurant');
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