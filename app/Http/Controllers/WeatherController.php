<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\WeatherHelper;
use Session;

class WeatherController extends Controller
{
    public function getWeather()
    {
		$weather = new WeatherHelper();
		$res = $weather->getWeather();
		if($res){
			$data['weather'] = $res;
			return view('informer',$data);
		}
		else{
			Session::flash('messages', "Яндекс не вернул данные о погоде.");
			return view('informer');
		}
	}
}
