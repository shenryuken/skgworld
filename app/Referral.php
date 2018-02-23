<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Baum\Node;

class Referral extends Node 
{
	public function user()
	{
		return $this->belongsTo('App\User');
	}
    
    public function wallet()
    {
    	return $this->hasOne('App\Wallet');
    }
}
