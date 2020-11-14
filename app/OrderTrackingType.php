<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTrackingType extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name', 'detail'
    ];

    public function scopeType ($query, $type_name)
    {
        return $query->whereName($type_name);
    }

    public function scopeOpen ($query)
    {
        return $query->whereName('open');
    }

    public function scopeUpdatePayment ($query)
    {
        return $query->whereName('update-payment');
    }

    public function scopePaid ($query)
    {
        return $query->whereName('paid');
    }

    public function scopeProducing ($query)
    {
        return $query->whereName('producing');
    }

    public function scopeProduced ($query)
    {
        return $query->whereName('produced');
    }

    public function scopeShipped ($query)
    {
        return $query->whereName('shipped');
    }

    public function scopeReceived ($query)
    {
        return $query->whereName('received');
    }

    public function order_trackings ()
    {
        return $this->hasMany(OrderTracking::class);
    }
}
