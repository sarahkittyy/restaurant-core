<?php

use App\Restaurant;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

/**
 * @brief INTERNAL FUNCTION ONLY
 * Used to upload images from the /restaurant endpoint to the /input endpoint
 */
function postImage($image)
{
	$client = new Client();
	
	$res = $client->request('POST', url('/api/post/image'), [
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
		
		//! Verifies that the restaurant isn't already in the DB
		$restaurants = Restaurant::all();
		if($restaurants->contains('name', '=', $request->name))
		{ 
			return response()->json([
				'success' => false,
				'response' => 'A restaurant with that name already exists.'
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
	
	/// Review upload endpoint
	Route::post('/review', function (Request $request) {
		/**
		 * title -> required
		 * body -> required
		 * rating -> required, must be an integer from 1 to 10
		 * restaurant -> required, name of the restaurant to associate with
		 */
		$validator = Validator::make($request->all(), [
			'title' => 'required',
			'body' => 'required',
			'rating' => 'required|integer|gte:1|lte:10',
			'restaurant' => 'required'
		]);
		
		// Validating the request
		if($validator->fails()) {
			return response()->json([
				'success' => false,
				'response' => 'Invalid review parameters.'
			], 400);
		}
		
		// Constructing the review
		$review = new Review;
		$review->title = $request->title;
		$review->body = $request->body;
		$review->rating = $request->rating;
		
		// Find and validate the restaurant given the name
		$restaurant = Restaurant::all()->where('name', '=', $request->restaurant)->first();
		if(is_null($restaurant))
		{
			return response()->json([
				'success' => false,
				'response' => 'Could not find restaurant '.$request->restaurant.'.',
			], 400);
		}
		$review->restaurant()->associate($restaurant);
		
		// Save the review
		$review->save();
		
		// Successful response.
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