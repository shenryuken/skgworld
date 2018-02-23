<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBonus extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'retail_profit', 'personal_rebate', 'direct_sponsor', 'do_group_bonus',
        'sdo_group_bonus', 'do_cto_pool', 'sdo_cto_pool', 'sdo_sdo', 'total_bonus', 'year', 'month'
    ];
}
