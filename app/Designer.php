<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designer extends Model
{
    use SoftDeletes;

    public $fillable = [
        'user_id', 'active'
    ];

    public function user()
    {
        return $this->belongsTo('users', 'user_id');
    }
}
