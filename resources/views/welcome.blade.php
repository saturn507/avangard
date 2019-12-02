<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">

	<title>АВАНГАРД - Техническое задание</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	
	<style>
		.pagination li {
		    padding: 1% 1%;
		}
	</style>
</head>

<body>
	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
		<h5 class="my-0 mr-md-auto font-weight-normal">АВАНГАРД - Техническое задание</h5>
		<nav class="my-2 my-md-0 mr-md-3">
			<a class="p-2 text-dark" href="{{ route('orders') }}">Заказы</a>
			<a class="p-2 text-dark" href="{{ route('weather') }}">Информер погоды</a>
		</nav>
	</div>

	<div class="container">
		
		@if(Session::has('messages'))
            <div class="alert alert-success" role="alert">
				{{Session::get('messages')}}
				{{Session::forget('messages')}}
			</div>
        @endif
		
		@section('content')
        @show

		<footer class="pt-4 my-md-5 pt-md-5 border-top">
			<div class="row">
				<div class="col-12 col-md">
					<small class="d-block mb-3 text-muted">&copy; 2019 Родионов Андрей</small>
				</div>
				<div class="col-6 col-md">
				</div>
				<div class="col-6 col-md">
				</div>
				<div class="col-6 col-md">
				</div>
			</div>
		</footer>
	</div>
</body>
</html>
