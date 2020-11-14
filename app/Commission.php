<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    public $dates = ['approved_at'];

    public $fillable = [
        'affiliate_id',
        'order_item_id',
        'total',
        'paid',
        'commission_status_id',
        'click_stat_id'
    ];


    public function scopeApproved($query)
    {
        return $query->where('commission_status_id', CommissionStatus::approved()->first()->id);
    }

    public function orderItem()
    {
        return $this->belongsTo('App\OrderItem', 'order_item_id');
    }

    public function clickStat()
    {
        return $this->belongsTo('App\ClickStat', 'click_stat_id');
    }

    public function status()
    {
        return $this->belongsTo('App\CommissionStatus', 'commission_status_id');
    }
}
