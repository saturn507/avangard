<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

	protected $guarded = [];
	
	// связь с моделью Partner
    public function partner()
	{
		return $this->hasOne('App\Partner','id','partner_id');;
	}
	
	public function orderProduct()
	{
		return $this->hasMany('App\OrderProduct');
	}
	

}
