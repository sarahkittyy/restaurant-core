<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Restaurant-Core</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

		<!-- Styles -->
		<!-- frontend is scary -->
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
                font-size: 84px;
				display: inline-block;
			}
			.underline {
				border-bottom: 2px solid grey;
			}
			.restaurant-box {
				outline: 1px solid #eee;
				width: 35%;
				padding: 8px;
				overflow: auto;
				text-align: center;
			}
			.restaurant-name {
				font-size: 40px;
				font-weight: bold;
			}
			.restaurant-address {
				font-size: 14px;
			}
			.image {
				align-content: left;
				justify-content: left;
				overflow: auto;
				padding: 3px;
				max-width: 50%;
				max-height: 100%;
			}
			.bottom-pad {
				margin-bottom: 25px;
				padding-bottom: 10px;
			}
			.upload-button {
				padding: 20px;
				margin: auto;
				border: 2px solid #ccc;
				background-color: #eee;
				outline: none;
				display: block;
			}
			.upload-button:hover {
				background-color: #ddd;
				border-style: inset;
				border-style: inset;
			}
			.average-review {
				color: black;
			}
		</style>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" type="text/javascript"></script>
		<script>
			function post() {
				window.location.pathname = '/new/restaurant';
			}
			function toRestaurant(restaurant) {
				window.location = "/restaurant?restaurant=" + encodeURIComponent(restaurant);
			}
			let star = '🌟';
			
			$(() => {
				$('.restaurant-box').each((i, elem) => {
					let restaurant = $(elem).children('.restaurant-name').html();
					$.ajax({
						url: '/api/averageReview?restaurant=' + encodeURIComponent(restaurant),
						method: 'GET',
						dataType: 'json'
					})
					.fail(function (res) {
						console.error(res.response);	
					})
					.then(function (res) {
						$(elem).children('#average-review')
							.html(res.response + ' ' + star);
					});
					
				});
				
				$('#sorting-form-submit').click(() => {
					window.location = '?' + $('#sorting-form').serialize();
				});
			});
		</script>
    </head>
    <body>
		<div class="full-width underline content bottom-pad">
			<div class="title">
				Home
			</div>
			<!--
			i swear to god i spent 45 minutes trying to center this button
			on the right of the header
			i quit
			it's a feature now
			-->
			<button type="button"
					class="upload-button"
					onclick="post()">
				Post Restaurant
			</button>
		</div>
		<div class="content center full-width bottom-pad">
			<form id="sorting-form">
				{{ Form::label('Sort By: ') }}
				{{ Form::select('sortBy', [
					'rating' => 'rating',
					'created_at' => 'recent',
					'name' => 'name',
				], $sortingBy) }}
				{{ Form::select('descend', [
					'1' => 'ascending',
					'0' => 'descending',
				], $descend)}}
				<button id="sorting-form-submit" type="button">Go</button>
			</form>
		</div>
		<div class="center">
			@foreach ($restaurants as $restaurant)
				<div class="restaurant-box center">
					<img align="left" class="image" src={{$restaurant->image}} />
					<a class="restaurant-name"
						href=""
						onclick="toRestaurant(`{{$restaurant->name}}`); return false;">
						{{$restaurant->name}}
					</a>
					<p class="restaurant-address">{{$restaurant->address}}</p>
					<p class="average-review" id="average-review"></p>
				</div>
				<br />
			@endforeach
			<div/>
    </body>
</html>
