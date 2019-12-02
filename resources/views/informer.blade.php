@extends('welcome')

@section('content')
	<h3>Погода в Брянске на {{date('d-m-Y H:i',time())}} (API запрос к https://tech.yandex.ru/weather/)</h3>
	@if(!empty($weather))
		<ul>
			<li>Температура воздуха: {{$weather['temp']}} °C (ощущается как {{$weather['feel']}} °C)</li>
			<li>{{$weather['condition']}}</li>
			<li>Cкорость ветра: {{$weather['wind_speed']}} м/с (местами до {{$weather['wind_gust']}} м/с)</li>
			<li>Направление ветра: {{$weather['wind_dir']}}</li>
			<li>Атмосферное давление: {{$weather['pressure']}}  мм рт. ст.</li>
			<li>Влажность: {{$weather['humidity']}} %</li>
		</ul>		
	@endif

@endsection