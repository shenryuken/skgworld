<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewUser extends Model
{
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

    public function newprofile()
    {
        return $this->morphOne('App\NewProfile', 'newprofileable');
    }
}
