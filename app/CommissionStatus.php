<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommissionStatus extends Model
{
    public $timestamps = false;

    public $fillable = [
        'name', 'detail'
    ];

    public function scopeApproving($query)
    {
        return $query->whereName('approving');
    }
    public function scopeApproved($query)
    {
        return $query->whereName('approved');
    }
    public function scopePaid($query)
    {
        return $query->whereName('paid');
    }
    public function scopeCancel($query)
    {
        return $query->whereName('cancel');
    }

    public function commissions()
    {
        return $this->hasMany('App\Commission');
    }
}
