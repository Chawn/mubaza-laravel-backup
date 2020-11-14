<?php namespace App;

use Faker\Provider\de_AT\Payment;
use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model {

    public $timestamps = false;
    public $fillable = [
        'name', 'detail'
    ];

    public static function waiting()
    {
        return self::whereName('waiting')->first();
    }
    public static function approve()
    {
        return self::whereName('approve')->first();
    }
    public static function paid()
    {
        return self::whereName('paid')->first();
    }
    public static function scopeCancel($query)
    {
        return $query->whereName('cancel');
    }
}
