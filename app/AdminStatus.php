<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminStatus extends Model
{
    public $timestamps = false;

    public $fillable = [
        'name', 'detai'
    ];

    public function scopeActive ($query)
    {
        return $query->whereName('active');
    }
    public function scopeInActive ($query)
    {
        return $query->whereName('inactive');
    }
    public function scopeBanned ($query)
    {
        return $query->whereName('banned');
    }
}
