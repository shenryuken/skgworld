<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
	protected $fillable = ['name','price'];

	public function stocks()
	{
		return $this->hasMany('App\Stock');
	}

	public function returnGoods()
	{
		return $this->hasMany('App\ReturnGoods');
	}

	public function productSales()
	{
		return $this->hasMany('App\ProductSale');
	}
}
