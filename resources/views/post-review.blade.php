<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>New Review</title>
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
			width: 20%;
			border: 2px solid #eee;
			margin: auto;
			padding: 20px;
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
		.error-box {
			border: 2px solid #eee;
			text-align: center;
			width: 10%;
			margin: auto;
		}
	</style>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" type="text/javascript"></script>
	<script>
		function back() {
			window.history.back();
		}
		$(document).ready(function() {
			$('#error-text').hide();
			$('#submit').click(function(e) {
				e.preventDefault();
				
				var $this = $(this);
				var form = $('form')[0];
				var formdata = new FormData(form);

				$.ajax({
					//TODO: clean this up for production
					url: '/api/post/review',
					method: 'POST',
					contentType: false,
					processData: false,
					data: formdata
				}).done(function (response) {
					window.location = '/success?msg=' + encodeURIComponent(response.response);
				}).fail(function (response) {
					let json = response.responseJSON;
					console.error(json);
					$('#error-text').show();
					$('#error-text').html(json.response);
					$('#error-text').css('border-color', '#ff2929');
				});
				
				return false;
			});
		});
	</script>
</head>
<body>
	<div class="full-width bottom-pad underline content">
		<div class="title">
			Upload a new review!
		</div>
		<button onclick="back()" type="button" class="button">
			Back
		</button>
	</div>
	<div class="main content">
		<form>
			
			<br />
			<button type="button" id="submit">Submit</button>
		</form>
	</div>
	<div id="error-text" class="error-box">
		
	</div>
</body>