<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    public function bonus_type()
    {
    	return $this->belongsTo('App\BonusType');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
