<?php

use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

/**
 * @brief INTERNAL FUNCTION ONLY
 * Used to upload images from the /restaurant endpoint to the /input endpoint
 */
function postImage($image)
{
	//TODO: verify that this would work in production
	// (cuz i'm pretty sure it won't)
	$client = new Client();
	
	$res = $client->request('POST', 'homestead.test/api/post/image', [
		'multipart' => [
			[
				'name' => 'image',
				'contents' => file_get_contents($image),
				'filename' => '/tmp/whatever',
			]
		],
	]);
	$json = json_decode($res->getBody());
	
	return $json->route;
}

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
			'image' => ['required', 'mimes:jpeg,bmp,png'],
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
		$img = postImage($request->image);
		$restaurant->image = $img;
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
			'image' => ['required', 'mimes:jpeg,bmp,png'],
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