<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'partners';

	public $timestamps = false;

	protected $guarded = [];
	
	// связь с моделью Order
    public function order()
	{
		return $this->hasMany('App\Order');
	}
}
