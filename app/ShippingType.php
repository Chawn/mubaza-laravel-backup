<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingType extends Model {

    public $timestamps = false;
    public $fillable = [
        'name', 'detail'
    ];

    public static function getDetail ($shipping_type_name)
    {
        return self::whereName($shipping_type_name)->first()->detail;
    }
}
