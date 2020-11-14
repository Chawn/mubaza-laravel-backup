<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssociateStatus extends Model
{
    public $timestamps = false;

    public $fillable = [
        'name', 'detail'
    ];

    // List all status name
    const ACTIVE = 'active';
    const DISABLE = 'disabled';
    const BAN = 'banned';

    /* Scope section */

    public function scopeActive ($query)
    {
        $test = ';';
        return $query->whereName(self::ACTIVE);
    }

    public function scopeDisable ($query)
    {
        return $query->whereName(self::DISABLE);
    }

    public function scopeBanned ($query)
    {
        return $query->whereName(self::BAN);
    }

    /* End scope section */

    /* Related model */

    public function associate ()
    {
        return $this->hasMany(Affiliate::class);
    }

    /* End related model */

}
