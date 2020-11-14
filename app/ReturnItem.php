<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    public $fillable = [
        'order_item_id'
    ];

    public function order_item ()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }
}
