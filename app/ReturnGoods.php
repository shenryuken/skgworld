<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnGoods extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'return_goods';

    public function product()
    {
    	return $this->belongsTo('App\Product');
    }
}
