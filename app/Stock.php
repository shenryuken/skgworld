<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public function product()
    {
    	$this->belongsTo('App\Product');
    }
}
