@extends('welcome')

@section('content')
<h3>Полная информация о заказе</h3>

<div class="row">
	<div class="col-sm">
		<hr />
		<form method="post" action="{{ route('editOrder') }}" >
			{{ csrf_field() }}
			<input type="hidden" name="orderId" value="{{$order['id']}}"/>
			<div class="form-group">
				<label for="emailOrder">Email клиента</label>
				<input type="text" name="email" class="form-control" id="emailOrder" placeholder="Email" value="{{ $order['email'] }}" required>
				@if(count($errors) > 0)
					<div class="alert alert-danger">
						@foreach($errors->all() as $error)
							<p>{{$error}}</p>
						@endforeach	
					</div>
				@endif
			</div>
			<div class="form-group">
				<label for="partnerOrder">Партнер</label>
				<select class="form-control" id="partnerOrder" name="partner">
					@foreach ($partner as $v)
						@if($v->id == $order['partner'])
							<option value="{{ $v->id }}" selected>{{ $v->name }}</option>
						@else
							<option value="{{ $v->id }}">{{ $v->name }}</option>
						@endif
					@endforeach
				</select>
			</div>
			<hr />
			<h5>Товарная часть</h5>
			
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">Нименование</th>
						<th scope="col">Количество</th>
						<th scope="col">Цена за шт.</th>
					</tr>
				</thead>
				<tbody>
					@if(!empty($order['products']))
						@foreach ($order['products'] as $product)
							<tr>
								<td>{{$product['name']}}</td>
								<td>{{$product['quantity']}} </td>
								<td>{{$product['price']}} p.</td>
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
			<hr />
			<div class="form-group">
				<label for="statusTicket">Статус</label>
				<select class="form-control" id="statusTicket" name="status">
					@foreach ($status as $v)
						@if($v->id == $order['status'])
							<option value="{{ $v->id }}" selected>{{ $v->name }}</option>
						@else
							<option value="{{ $v->id }}">{{ $v->name }}</option>
						@endif
					@endforeach
				</select>
			</div>
			<p>Общая сумма заказа: {{ $order['totalPrice'] }} руб.</p>
			<button type="submit" class="btn btn-primary">Изменить</button>
		</form>
		
	</div>
	<div class="col-sm">
		
	</div>
</div>
@endsection