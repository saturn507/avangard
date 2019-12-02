<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Status;
use App\Partner;
use App\OrderCRUD;
use Session;
use Validator;
use Mail;

class OrderController extends Controller
{
	private $orderCRUD;
	
	public function __construct(OrderCRUD $orderCRUD)
	{
		$this->orderCRUD = $orderCRUD;
	}
	
	/**Все заявки + фильтрация по условию
	* 
	* @param string $filter
	* 
	* @return mixed
	*/
    public function allOrders($filter = 'all')
    {
    	$data = $this->orderCRUD->orderList($filter);
    	if(!$data){
			Session::flash('messages', "Заказы не найдены.");
		}
		return view('orders',$data);
	}
	
	/** Получить один заказ
	* 
	* @param int $id
	* 
	* @return mixed
	*/
	public function getOrder($id)
	{		
    	$res = $this->orderCRUD->getOrder($id);
    	if($res){
    		$data['status'] = Status::all();
			$data['partner'] = Partner::all();
			$data['order'] = $res;
    		return view('order',$data);
		}
		else{
			Session::flash('messages', "Заказ не $id найден.");
			return back();
		}
		
	}
	
	/**Изменение заказа
	* 
	* @param Illuminate\Http\Request $request
	* 
	* @return mixed
	*/
	public function editOrder(Request $request)
	{
		// Валидатор формы
    	$rules = [
		    'email' => 'required|email',
		];
		$messages = [
			'required' => 'Обязательно к заполнению',
			'email'  => 'Только email',
		];
		
    	$validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Изменения в заказ
        $order = Order::find($request->orderId);
        $oldStatus = $order->status_id; //Старый статус
        $order->client_email = $request->email;
        $order->partner_id   =  $request->partner;
        $order->status_id    = $request->status;
        $order->save();
        
        $mes = ''; // эмуляция отправки почтовых сообщений
        
        // Отправить email при статусе "завершен"
        if($oldStatus != $request->status and $request->status == 3){
        	$mes = $this->sendEmail($request->orderId);
        }
        
        Session::flash('messages', "Заказ ".$request->orderId." сохранен.\n".$mes);
		return redirect()->route('orders');
	}
	
	/**
	* 
	* @param int $id - ID заказа
	* 
	* @return string - сщщбщени о отправке email
	*/
	private function sendEmail($id)
	{
		$data['subject'] = "Заказ № ".$id." завершен.";
    	$data['text'] = '';
    	$o = $this->orderCRUD->getOrder($id);
    	if(count($o['products']) > 0){
    		foreach($o['products'] as $v){
				$data['text'] .= $v['name'].' / '.$v['quantity'].' шт. / '.$v['price'].' руб. ,';
				$data['vendor_email'][] = $v['vendor_email'];
			}
		}
		
		$data['text'] .= 'Общая стоимость заказа: '.$o['totalPrice'].' руб.';
		$data['partner'] = [
			'email' => $o['email'],
			'name'  => $o['name'],
		];
		
		// Отправка почты, нужна изменить конфигурацию smtp в .env
		/*Mail::send('emails.test', $data, function ($message) use ($data) {
			$message->from('test@example.com', 'Laravel');
			$message->to($data['partner']['email'],$data['partner']['name']);
			$message->cc($data['vendor_email']);
			$message->subject($data['subject']);
		});*/
		$mes = "Отправлен email партнеру: ".$data['partner']['email'].", ".$data['partner']['name'].". ";
    	$mes .= "И поставщикам: ";
    	foreach($data['vendor_email'] as $v){
			$mes .= $v.", ";
		}
		$mes .= "С заголовкос письма: ";
		$mes .= $data['subject'];
		$mes .= "С текстом письма: ";
		$mes .= $data['text'];
		
		return $mes;
	}
}
