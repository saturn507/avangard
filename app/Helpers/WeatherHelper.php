<?php

namespace App\Helpers;

class WeatherHelper{
	
	private $coord = ['53.243562', '34.363407']; // координаты Брянска
	private $key = 'd085d901-ec83-45ef-9611-fe406d202971';
	private $url;
	
	/** Получить данные о погоде
	* 
	* 
	* @return mixed
	*/
	public function getWeather()
	{
		$this->url = "https://api.weather.yandex.ru/v1/forecast?lat=".$this->coord[0]."&lon=".$this->coord[1]."&lang=ru_RU";
		$res = $this->CURL();
		if(!empty($res->fact)){
			return $this->structureData($res->fact);
		}
		else{
			return false;
		}		
	}
	
	/** Получить погоду с удаленого сервера
	* 
	* 
	* @return array
	*/
	private function CURL()
	{	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-Yandex-API-Key: ".$this->key]);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:6.0.2) Gecko/20100101 Firefox/6.0.2');
        $result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result);
	}
	
	
	/**Сруктурирование данных
	* 
	* @param array $data
	* 
	* @return array
	*/
	private function structureData($data)
	{
		return [
			'temp' => !empty($data->temp)? $data->temp : ' - ',
			'feel' => !empty($data->feels_like)? $data->feels_like : ' - ',
			'condition' => !empty($data->condition)? self::condition($data->condition) : ' - ',
			'wind_speed' => !empty($data->wind_speed)? $data->wind_speed : ' - ',
			'wind_gust' => !empty($data->wind_gust)? $data->wind_gust : ' - ',
			'wind_dir' => !empty($data->wind_dir)? self::directionWind($data->wind_dir) : ' - ',
			'pressure' => !empty($data->pressure_mm)? $data->pressure_mm : ' - ',
			'humidity' => !empty($data->humidity)? $data->humidity : ' - ',
		];
		
	}
	
	/** Расшифровка погодного описания.
	* 
	* @param str $data
	* 
	* @return str
	*/
	private static function condition($data)
	{
		$arr = [
			'clear'                            => 'ясно',
			'partly-cloudy'                    => 'малооблачно',
			'cloudy'                           => 'облачно с прояснениями',
			'overcast'                         => 'пасмурно',
			'partly-cloudy-and-light-rain'     => 'небольшой дождь',
			'partly-cloudy-and-rain'           => 'дождь',
			'overcast-and-rain'                => 'сильный дождь',
			'overcast-thunderstorms-with-rain' => 'сильный дождь, гроза',
			'cloudy-and-light-rain'            => 'небольшой дождь',
			'overcast-and-light-rain'          => 'небольшой дождь',
			'cloudy-and-rain'                  => 'дождь',
			'overcast-and-wet-snow'            => 'дождь со снегом',
			'partly-cloudy-and-light-snow'     => 'небольшой снег',
			'partly-cloudy-and-snow'           => 'снег',
			'overcast-and-snow'                => 'снегопад',
			'cloudy-and-light-snow'            => 'небольшой снег',
			'overcast-and-light-snow'          => 'небольшой снег',
			'cloudy-and-snow'                  => 'снег',
		];
		if(!empty($arr[$data])){
			return $arr[$data];
		}
		else{
			return '';
		}
	}
	
	/** Расшифровка направления ветра
	* 
	* @param str $data
	* 
	* @return str
	*/
	private static function directionWind($data)
	{
		$arr = [
			'nw' => 'северо-западное',
			'n'  => 'северное',
			'ne' => 'северо-восточное',
			'e'  => 'восточное',
			'se' => 'юго-восточное',
			's'  => 'южное',
			'sw' => 'юго-западное',
			'w'  => 'западное',
			'с'  => 'штиль',
		];
		if(!empty($arr[$data])){
			return $arr[$data];
		}
		else{
			return '';
		}
	}
	
}