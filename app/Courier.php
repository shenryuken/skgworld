<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    public function personnels()
    {
    	return $this->morphMany('App\Personnel', 'personnelable');
    }
}
