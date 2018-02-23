<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SdoLicense extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sdo_licenses';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];
}
