<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewProfile extends Model
{
    protected $guarded = array();
    /**
     * Get all of the owning profileable models.
     */
    public function newprofileable()
    {
        return $this->morphTo();
    }
}
