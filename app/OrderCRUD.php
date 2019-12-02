<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;


class OrderCRUD extends Model
{
	/**Возвращает данные по всем заказам + фильтры
	* 
	* @param string $filter
	* 
	* @return mixed
	*/
    public function orderList($filter)
    {
		$pagination = 20;
    	
		$o = Order::select(['orders.id','partners.name as partner','status.name as status'])
						->leftJoin('partners','partners.id','=','orders.partner_id')
						->leftJoin('status','status.id','=','orders.status_id');
					
		switch($filter){
			case 'overdue':
				$o->where('orders.delivery_dt', '<', 'str_to_date('.date("Y-m-d H:i:s",time()).',"%d/%m/%Y %h:%i:%s")');
				$o->where('orders.status_id', '=', 2);
				$o->orderBy('orders.delivery_dt', 'desc');
				$pagination = 50;
				break;
			case 'current':
				$o->whereBetween('orders.delivery_dt', 
					[
						date("Y-m-d H:i:s",time()), 
						date("Y-m-d H:i:s",time() + 24 * 60 * 60)
					]);
				$o->where('orders.status_id', '=', 2);
				$o->orderBy('orders.delivery_dt', 'asc');
				break;
			case 'new':
				$o->where('orders.delivery_dt', '<', 'str_to_date('.date("Y-m-d H:i:s",time()).',"%d/%m/%Y %h:%i:%s")');
				$o->where('orders.status_id', '=', 1);
				$o->orderBy('orders.delivery_dt', 'asc');
				$pagination = 50;
				break;
			case 'complet':
				$o->whereBetween('orders.delivery_dt', 
				[
					date("Y-m-d",time())." 00:00:00", 
					date("Y-m-d",time())." 23:59:59"
				]);
				$o->where('orders.status_id', '=', 3);
				$o->orderBy('orders.delivery_dt', 'desc');
				$pagination = 50;
				break;
			default:
				$o->orderBy('orders.id', 'desc');
				break;
		}
		
		$orders = $o->paginate($pagination);
		
		if($orders){
								
			foreach($orders as $v){
				
				$products = [];
				$orderPrice = 0; // Общая стоимость заказа
				
				// Запрос товарных вложений
				$p = OrderProduct::select(['order_products.quantity','order_products.price','products.name',])
										->leftJoin('products','products.id','=','order_products.product_id')
										->where('order_products.order_id', '=', $v->id)
										->get();
										
				foreach($p as $product){
					$orderPrice += $product->quantity * $product->price;
					$products[] = [
						'name'     => $product->name,
						'quantity' => $product->quantity,
						'price' => $product->price,
					];
				}
				
				$order[] = [
					'id'       => $v->id,
					'partner'  => $v->partner,
					'price'    => $orderPrice,
					'status'   => $v->status,
					'products' => $products,
				];
			}
						
			return [
				'orders'     => $order,
				'pagination' => $orders->render(),
			];
		}
		else{
			return false;
		}						
	}
	
	/** Возвращает конкретный заказ по ID 
	* 
	* @param int $id
	* 
	* @return mixed
	*/
	public function getOrder($id)
	{
		$totalPrice = 0;
		$product = [];
		$order = Order::find($id);
		
		if(!empty($order)){
			$data = [
				'id'      => $order->id,
				'email'   => $order->client_email,
				'name'    => $order->partner->name,
				'partner' => $order->partner_id,
				'status'  => $order->status_id,
			];
			
			foreach($order->orderProduct as $op){
				$totalPrice += $op->price * $op->quantity;
				$product[] = [
					'quantity'     => $op->quantity,
					'name'         => Product::find($op->product_id)->name,
					'price'        => $op->price,
					'vendor_email' => Product::find($op->product_id)->vendor->email,
				];
			}
			
			$data['products']   = $product;
			$data['totalPrice'] = $totalPrice;
			
			return $data;
		}
		else{
			return false;
		}
	}
}
