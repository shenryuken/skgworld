<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
	protected $fillable = ['user_id','personal_rebate'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
