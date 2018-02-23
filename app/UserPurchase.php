<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPurchase extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_purchases';

    public function product()
    {
    	return $this->belongsTo('App\Product');
    }

}
