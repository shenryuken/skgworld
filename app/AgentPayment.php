<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentPayment extends Model
{
    public function agentInvoice()
    {
    	return $this->belongsTo('App\AgentInvoice');
    }
}
