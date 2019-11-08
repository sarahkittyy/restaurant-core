<?php

use Illuminate\Http\Request;

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
    return view('welcome');
});

/**
 * @brief Displays a page focused on the specific restaurant at hand
 */
Route::get('/restaurant/{name}', function ($name) {
	return 'restaurant '.$name;
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