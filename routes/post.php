<?php

use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
			], 400);
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
		], 200);
	});
	
	/// Image uplaod endpoint
	Route::post('/image', function (Request $request) {
		$validator = Validator::make($request->all(), [
			'image' => 'required|file'
		]);
		
		if($validator->fails()) {
			return response()->json([
				'success' => false,
				'response' => 'No image given.'
			], 400);
		}
		
		$image = $request->file('image');
		$name = 'image_'.Str::random(10).'.'.$image->extension();
		
		$image->storeAs('.', $name, 'public');
		
		return response()->json([
			'success' => true,
			'response' => 'Successfully added image to cdn.',
			'route' => '/cdn/'.$name,
		], 200);
	});
}