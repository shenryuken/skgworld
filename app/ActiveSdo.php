<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveSdo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'active_sdo';

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function licenses()
    {
        return $this->hasMany('App\ActiveSdoLicense');
    }
}
