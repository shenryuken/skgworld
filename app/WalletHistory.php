<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wallet_histories';

    protected $fillable = [
    						'user_id',
    						'rank_id',
    						'p_wallet',
    						'rmvp',
    						'pv',
    						'rmvp_first_purchased',
    						'pv_first_purchased',
    						'month',
    						'year',
    					];
}
