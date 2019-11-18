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
		button {
			padding: 20px;
			margin: auto;
			border: 2px solid #ccc;
			background-color: #eee;
			outline: none;
			display: block;
		}
		button:hover {
			background-color: #ddd;
			border-style: inset;
			border-style: inset;
		}
	</style>
	<script>
		function toReview(restaurant)
		{
			console.log(restaurant);
			window.location = '/new/review?restaurant=' + encodeURIComponent(restaurant);
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
			<h2 class="title">{{$restaurant->name}}</h2>
			<h4 class="location">{{$restaurant->address}}</h4>
		</div>
		<br />
		<button class="iblock"
				onclick="toReview('{{$restaurant->name}}')">New Review</button>
		<button class="iblock"
				onclick="window.location = '/'">Home</button>
	</div>
	<!--TODO: add reviews here -->
</body>
</html>