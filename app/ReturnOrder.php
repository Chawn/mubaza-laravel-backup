<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnOrder extends Model
{
    public $fillable = [
        'order_id',
        'amount',
        'bank_account_id',
        'bank_account_name',
        'bank_name',
        'transferred_on',
        'admin_id'
    ];

    public function order ()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function admin ()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function item () {
        return $this->hasMany(ReturnItem::class);
    }
}
