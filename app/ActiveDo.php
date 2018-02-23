<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveDo extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'active_do';

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
