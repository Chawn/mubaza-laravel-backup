<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PayoutType extends Model {

    public $timestamps = false;
    public $fillable = [
        'name', 'detail'
    ];

}
