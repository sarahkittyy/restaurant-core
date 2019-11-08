<?php

use App\Restaurant;
use Illuminate\Http\Request;

/**
 * @brief Endpoints for uploading new objects to the server.
 */
function posts() {
	/// Restaurant upload endpoint
	Route::post('/restaurant', function (Request $request) {
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
			// Failed json response
			return response()->json([
				'success' => false,
				'response' => 'Invalid restaurant specifics.'
			]);
		}
		
		// Creates and saves the restaurant model.
		$restaurant = new Restaurant;
		$restaurant->name = $request->name;
		$restaurant->address = $request->address;
		$restaurant->image = $request->image;
		$restaurant->save();
		
		// Successful json response
		return response()->json([
			'success' => true,
			'response' => 'Successfully submitted data.'
		]);
	});
}