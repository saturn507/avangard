<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
  return redirect()->route('orders');
});

Route::get('/orders/{filter?}', 'OrderController@allOrders')->where(['filter' => '[a-z]+'])->name('orders');
Route::get('/order/{id}', 'OrderController@getOrder')->where(['id' => '[0-9]+'])->name('order');
Route::post('/order', 'OrderController@editOrder')->name('editOrder');
Route::get('/weather', 'WeatherController@getWeather')->name('weather');

