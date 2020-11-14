<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PayoutStatus extends Model {

    public $timestamps = false;
    public $fillable = [
        'name', 'detail'
    ];

    public function scopeApproved ($query)
    {
        return $query->whereName('approved');
    }
    public function scopePaid ($query)
    {
        return $query->whereName('paid');
    }
}
