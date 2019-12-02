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
			<div>
			<p>
				<h3>Тестовое задание</h3>


#### Обязательно
- Создать страницу на которой выводится текущая температура в Брянске (запрос из php) (Работа с api какого-либо сервиса например: https://tech.yandex.ru/weather/)<br />

- Создать страницу со списоком заказов в табличном виде<br />
    - поля <br />
        - ид_заказа <br />
        - название_партнера <br />
        - стоимость_заказа <br />
        - наименование_состав_заказа <br />
        - статус_заказа<br />
    - ид_заказа - ссылка на редактирование заказа в новой вкладке<br />
- Создать страницу редактирования заказа<br />
    - поля для редактирования:<br />
        - email_клиента(редактирование, обязательное)<br />
        - партнер(редактирование, обязательное)<br />
        - продукты(вывод наименования + количества единиц продукта)<br />
        - статус заказа(редактирование, обязательное)<br />
        - стоимость заказ(вывод)<br />
        - сохранение изменений в заказе<br />
<br />
#### Не обязательно (если желаете лучше продемонстрировать свои умения)<br />
- Дополнительный функционал для списка заказов<br />
    - список заказов разбить на страницы<br />
        - владка просроченные<br /><br />
            - дата доставки раньше текущего момента<br />
            - статус заказа 10<br />
            - сортировка по дате доставки по убыванию<br />
            - ограничение 50 штук<br />
        - текущие<br /><br />
            - дата доставки 24 часа с текущего момента<br />
            - статус заказа 10<br />
            - сортировка по дате доставки по возрастанию<br />
        - новые<br /><br />
            - дата доставки после текущего момента<br />
            - статус заказа 0<br />
            - сортировка по дате доставки по возрастанию<br />
            - ограничение 50<br />
        - выполненные<br /><br />
            - дата доставки в текущие сутки<br />
            - статус заказа 20<br />
            - сортировка по дате доставки по убыванию<br />
            - ограничение 50<br />
- Дополнительный функционал для страницы редактирования заказа<br /><br />
    - при установке статуса заказа "завершен" требуется отправить email - партнеру и всем поставщикам продуктов из заказа<br />
        - заказ №(номер) завершен<br />
        - текст состав заказа (список), стоимость заказа (значение)<br />
        </p>
			</div>
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
