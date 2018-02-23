<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    /**
     * Get all of the owning profileable models.
     */
    public function personnelable()
    {
        return $this->morphTo();
    }
}
