<?php

namespace App;

use App\Notifications\UserResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','mobile_no', 'introducer', 'rank_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email_token',
    ];

    // public function setPasswordAttribute($password)
    // {   
    //     $this->attributes['password'] = bcrypt($password);
    // }

    // *
    //  * Send the password reset notification.
    //  *
    //  * @param  string  $token
    //  * @return void
     
    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new UserResetPassword($token));
    // }

    public function profile()
    {
        return $this->morphOne('App\Profile', 'profileable');
    }

    public function account()
    {
        return $this->hasOne('App\Account');
    }

    public function wallet()
    {
        return $this->hasOne('App\Wallet')->withDefault([
            'retail_profit' => 0,
            'personal_rebate' => 0,
            'direct_sponsor' => 0, 
        ]);
    }

    public function rank()
    {
        return $this->belongsTo('App\Rank');
    }

    public function referral()
    {
        return $this->hasOne('App\Referral');
    }

    public function userPurchases()
    {
        return $this->hasMany('App\UserPurchase');
    }

    public function userSales()
    {
        return $this->hasMany('App\UserSale');
    }

    public function stores()
    {
        return $this->hasMany('App\Store');
    }

    public function active_do()
    {
        return $this->hasOne('App\ActiveDo')->withDefault([
            'do_group_bonus' => 0,
            'cto_value_share' => 0,
        ]);
    }

    public function active_sdo()
    {
        return $this->hasOne('App\ActiveSdo')->withDefault([
            'sdo_group_bonus' => 0,
            'cto_value_share' => 0,
            'sdo_to_sdo_bonus'=> 0
        ]);
    }

    public function userBonus()
    {
        return $this->hasMany('App\UserBonus');
    }
}
