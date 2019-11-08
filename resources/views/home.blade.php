<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Restaurant-Core</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
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
				margin: 0;
			}
            .flex-center {
                display: flex;
                justify-content: center;
            }
			.center {
				width: 100%;
				margin: auto;
			}
            .position-ref {
                position: relative;
            }
            .content {
				text-align: center;
				margin: 0;
				padding: 5px;
            }
            .title {
                font-size: 84px;
			}
			.underline {
				border-bottom: 2px solid grey;
			}
			.restaurant-box {
				outline: 1px solid #eee;
				width: 35%;
				padding: 8px;
				overflow: auto;
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
        </style>
    </head>
    <body>
        <div style="padding-bottom: 10px; margin-bottom: 25px;" class="flex-center position-ref full-width underline">
            <div class="content">
                <div class="title">
					Home
                </div>
			</div>
        </div>
		<div class="center">
			@foreach ($restaurants as $restaurant)
				<div class="restaurant-box center">
					<img align="left" class="image" src={{$restaurant->image}} />
					<p class="restaurant-name content">{{$restaurant->name}}</p>
					<p class="restaurant-address content">{{$restaurant->address}}</p>
				</div>
				<br />
			@endforeach
		</div>
    </body>
</html>
