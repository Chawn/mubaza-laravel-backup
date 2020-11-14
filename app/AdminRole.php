<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    public $timestamps = false;

    public $fillable = [
        'name', 'detail'
    ];
}
