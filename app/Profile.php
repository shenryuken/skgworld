<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	protected $guarded = array();
    /**
     * Get all of the owning profileable models.
     */
    public function profileable()
    {
        return $this->morphTo();
    }
}
