<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Restaurant</title>
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
	<style>
		html, body {
			background-color: #fff;
			color: #636b6f;
			font-family: 'Nunito', sans-serif;
			font-weight: 200;
			height: 100vh;
			margin: 0;
		}
		.full-width {
			width: 100%;
			margin: auto;
		}
		.half-width {
			width: 20%;
			display: inline-block;
		}
		.center {
			width: 100%;
			margin: auto;
		}
		.content {
			align-content: center;
			text-align: center;
			justify-content: center;
		}
		.title {
			font-size: 60px;
			display: inline-block;
			margin-bottom: 0;
		}
		.location {
			font-size: 20px;
		}
		.underline {
			border-bottom: 2px solid grey;
		}
		.bottom-pad {
			margin-bottom: 25px;
			padding-bottom: 10px;
		}
		.img-bound {
			padding: 20px;
			padding-bottom: 0;
			display: inline-block;
			max-width: 200px;
			height: auto;
		}
		.iblock {
			display: inline-block;
			margin: 3px;
		}
		.generic-button {
			padding: 20px;
			margin: auto;
			border: 2px solid #ccc;
			background-color: #eee;
			outline: none;
		}
		.generic-button:hover {
			background-color: #ddd;
			border-style: inset;
			border-style: inset;
		}
		.review-container {
			border: 3px solid #eee;
			width: 50%;
			margin: auto;
		}
		.error-box {
			border: 2px solid #eee;
			text-align: center;
			width: 10%;
			margin: auto;
		}
		.review-title {
			font-size: 60px;
			padding: 10px;
			color: black;
		}
		.review-body {
			
		}
		.review-rating {
			color: black;
			font-size: 50px;
			padding: 10px;
		}
		.average-review {
			color: black;
			font-size: 30px;
			padding-top: 0px;
			margin-top: 0px;
		}
	</style>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" type="text/javascript"></script>
	<script>
		$(() => {
			// A lil hacky, but it works
			let restaurant = $('h2.title').html();

			$("#reviews").hide();
			$("#error-text").hide();
			$('#make-review').click(() => {
				window.location = '/new/review?restaurant=' + encodeURIComponent(restaurant);
			});
			$.ajax({
				url: '/api/reviews?restaurant=' +
						encodeURIComponent(restaurant) + '&' + 
						$('#sorting-form').serialize(),
				method: 'GET'
			})
			.fail(function (res) {
				$('#error-text').show();
				$('#error-text').html(res.responseJSON.response);
				$('#error-text').css('border-color', '#ff2929');
			})
			.done(function (res) {
				let container = $('#reviews');
				container.show();
				let reviews = res.reviews;
				reviews.forEach(review => {
					container.append(reviewBuilder(review.title, review.body, review.rating));
				});
			});
			$.ajax({
				url: '/api/averageReview?restaurant=' +
						encodeURIComponent(restaurant),
				method: 'GET'
			})
			.fail(function (res) {
				console.error(res.response);
			})
			.done(function (res) {
				let star = '🌟';
				
				$('#average-review').html('Rating: ' + res.response + ' ' + star);
			});
			
			$('#sorting-form-submit').click(() => {
				window.location =
					'/restaurant?restaurant=' +
					encodeURIComponent(restaurant) +
					'&' + $('#sorting-form').serialize();
			});
		});
		function reviewBuilder(title, body, rating)
		{
			return `
			<div class="review">
				<span class="review-title">${title}</span>
				<span class="review-rating">${rating} 🌟</span>
				<p class="review-body">${body}</p>
			</div>
			`;
		}
	</script>
</head>
<!-- DATA AVAILABLE
	- $restaurant->name
	- $restaurant->address
	- $restaurant->image
-->
<body>
	<div class="full-width underline content bottom-pad">
		<img src={{$restaurant->image}} class="img-bound" />
		<div class="half-width">
			<h2 class="title" id="restaurant-name">{{$restaurant->name}}</h2>
			<h4 class="location">{{$restaurant->address}}</h4>
		</div>
		<p id="average-review" class="average-review"></p>
		<button class="generic-button iblock"
				id="make-review">New Review</button>
		<button class="generic-button iblock"
				onclick="window.location = '/'">Home</button>
	</div>
	<div class="content center full-width bottom-pad">
		<form id="sorting-form">
			{{ Form::label('Sort by: ') }}
			{{ Form::select('sortBy', [
				'rating' => 'rating',
				'created_at' => 'recent',
				'title' => 'title',
			], $sortingBy) }}
			{{ Form::select('descend', [
				'0' => 'ascending',
				'1' => 'descending'
			], $descend) }}
			<button id="sorting-form-submit" type="button">Go</button>
		</form>
	</div>
	<div id="reviews" class="review-container">
		
	</div>
	<div id="error-text" class="error-box"></div>
</body>
</>