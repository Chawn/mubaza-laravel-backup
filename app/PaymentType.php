<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model {

    public $timestamps = false;
    public $fillable = [
        'name', 'detail'
    ];

    public function scopeTransfer ($query)
    {
        return $query->whereName('transfer')->first();
    }
    public function scopeCard ($query)
    {
        return $query->whereName('card')->first();
    }
}
