<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function order()
    {
    	return $this->hasOne('App\Order');
    }

    public function payments()
    {
    	return $this->hasMany('App\Payment');
    }
}
