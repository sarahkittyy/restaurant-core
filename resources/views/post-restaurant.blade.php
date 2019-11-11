<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>New Restaurant</title>
	<style>
		html, body {
			background-color: #fff;
			color: #636b6f;
			font-family: 'Nunito', sans-serif;
			font-weight: 200;
			height: 100vh;
			margin: 0;
		}
		.title {
			font-size: 72px;
			display: inline;
		}
		.underline {
			border-bottom: 2px solid grey;
		}
		.full-width {
			width: 100%;
			margin: auto;
		}
		.content {
			align-content: center;
			text-align: center;
		}
		.bottom-pad {
			margin-bottom: 25px;
			padding-bottom: 10px;
		}
		.main {
			width: 40%;
			border: 2px solid #eee;
			margin: auto;
		}
		.button {
			padding: 20px;
			margin: auto;
			border: 2px solid #ccc;
			background-color: #eee;
			outline: none;
			display: block;
		}
		.button:hover {
			background-color: #ddd;
			border-style: inset;
			border-style: inset;
		}
	</style>
	<script>
		function back() {
			window.history.back();
		}
	</script>
</head>
<body>
	<div class="full-width bottom-pad underline content">
		<div class="title">
			Upload a new restaurant
		</div>
		<button onclick="back()" type="button" class="button">
			Back
		</button>
	</div>
	<div class="main content">
		
	</div>
</body>
</html>