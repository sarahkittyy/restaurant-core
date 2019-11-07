<!DOCTYPE html>
<html lang="en">
<head>
	<title>Restaurant-Core API v1.0.0</title>
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
	<style>
		html {
			font-family: 'Nunito', sans-serif;
		}
		.text {
			font-size: 50px;
			text-decoration: underline;
			padding: 5px;
			width: 100%;
			margin: auto;
		}
		.center {
			padding: 70px 0;
			text-align: center;
		}
		.message {
			font-size: 30px;
		}
		.return-link {
			
		}
	</style>
</head>
<body>
	<div class="center">
		<p class="text">
			Success
		</p>
		<p class="message">
			{{ $msg }}
		</p>
		<a class="return-link" href="/">Go Home</a>
	</div>
</body>
</html>