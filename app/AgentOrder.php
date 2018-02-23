<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentOrder extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function agentInvoice()
    {
    	return $this->belongsTo('App\AgentInvoice');
    }

    public function agentOrderItems()
    {
    	return $this->hasMany('App\AgentOrderItem');
    }

    public function agentShipment()
    {
        return $this->hasOne('App\AgentShipment');
    }
}
