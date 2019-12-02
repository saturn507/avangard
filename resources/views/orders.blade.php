@extends('welcome')

@section('content')
<h3>Таблица заказов</h3>
<div class="container">
	<a href="{{route('orders')}}">все</a> | 
	<a href="{{route('orders', ['filter' => 'overdue'])}}">просроченные</a> | 
	<a href="{{route('orders', ['filter' => 'current'])}}">текущие</a> | 
	<a href="{{route('orders', ['filter' => 'new'])}}">новые</a> | 
	<a href="{{route('orders', ['filter' => 'complet'])}}">выполненные</a>
</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th scope="col">ID</th>
			<th scope="col">Партнер</th>
			<th scope="col">Стоимость заказа</th>
			<th scope="col">Состав заказа</th>
			<th scope="col">Статус</th>
		</tr>
	</thead>
	<tbody>
		@if(!empty($orders))
			@foreach ($orders as $order)
				<tr>
				    <th scope="row"><a href="{{route('order', ['id' => $order['id']])}}">{{$order['id']}}</a></th>
					<td>{{$order['partner']}}</td>
					<td>{{$order['price']}} p.</td>
					<td>
						<ul>
							@foreach($order['products'] as $product)
								<li>{{$product['name']}} | {{$product['quantity']}} шт. | {{$product['price']}} руб./шт.</li>
							@endforeach
						</ul>
					</td>
					<td>{{$order['status']}}</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>

{{$pagination}}

@endsection