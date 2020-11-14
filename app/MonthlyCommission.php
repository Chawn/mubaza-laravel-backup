<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlyCommission extends Model
{
    use SoftDeletes;
    protected $dates = ['start', 'end'];

    protected $fillable = [
        'total', 'user_id',
        'start', 'end',
        'monthly_commission_status_id',
        'affiliate_qty',
        'affiliate_sell',
        'affiliate_commission',
        'creator_qty',
        'creator_sell',
        'creator_commission'
    ];

    public function scopeApproved ($query)
    {
        return $query->where('monthly_commission_status_id', MonthlyCommissionStatus::approved()->first()->id);
    }

    public function scopePaid ($query)
    {
        return $query->where('monthly_commission_status_id', MonthlyCommissionStatus::paid()->first()->id);
    }

    public function status ()
    {
        return $this->belongsTo(MonthlyCommissionStatus::class, 'monthly_commission_status_id');
    }

    public function user ()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
