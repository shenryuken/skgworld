<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function invoice()
    {
    	return $this->belongsTo('App\Invoice');
    }

    public function orderItems()
    {
    	return $this->hasMany('App\OrderItem');
    }

    public function shipment()
    {
        return $this->hasOne('App\Shipment');
    }
}
