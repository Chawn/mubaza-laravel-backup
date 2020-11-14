<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthlyCommissionStatus extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name', 'detail'
    ];

    public function scopeApproved ($query)
    {
        return $query->where('name', 'approved');
    }

    public function scopePending ($query)
    {
        return $query->whereName('pending');
    }
    public function scopePaid ($query)
    {
        return $query->where('name', 'paid');
    }
}
