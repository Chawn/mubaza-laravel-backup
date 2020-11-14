<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    public $fillable = [
        'order_id', 'full_name', 'address',
        'building', 'district',
        'province', 'zipcode',
        'phone', 'email', 'tracking_code'
    ];

    public function order()
    {
        return $this->belongsTo('App\Order', 'id');
    }
}
