<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTracking extends Model
{
    protected $fillable = [
        'order_tracking_type_id',
        'detail',
        'order_id',
    ];

    public function scopeType ($query, $type_name)
    {
        return $query->where('order_tracking_type_id', OrderTrackingType::type($type_name)->first()->id);
    }

    public function order ()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function type ()
    {
        return $this->belongsTo(OrderTrackingType::class, 'order_tracking_type_id');
    }
}
