<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommissionRate extends Model
{
    public $fillable = [
        'min', 'max', 'percent', 'active'
    ];

    /**
     * Get commission rate by quantity
     * @param $quantity
     * @return mixed
     */
    public static function getPercent($quantity)
    {
        $commission = CommissionRate::where('min', '<=', $quantity)
            ->where('max', '>=', $quantity)
            ->where('active', '=', true)
            ->first();

        if(!$commission) {
            return 0;
        }

        return floatVal($commission->percent);
    }
}
