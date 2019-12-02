<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

	public $timestamps = false;

	protected $guarded = [];
	
	// связь с моделью Vendor
    public function vendor()
	{
		return $this->hasOne('App\Vendor','id','vendor_id');;
	}
}
