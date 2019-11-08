<?php

use Illuminate\Http\Request;

/**
 * @brief Endpoints for uploading new objects to the server.
 */
function posts() {
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
		
		return response()->json([
			'success' => true,
			'response' => 'Successfully submitted data.'
		]);
	});
}