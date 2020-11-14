<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model {

	public $timestamps = false;
    public $fillable = [
        'name', 'detail'
    ];

    /* Order status constant */
    const OPEN = 'open';
    const CANCEL = 'cancel';
//    const CANCEL_BY_USER = 'cancel_by_user';
//    const CANCEL_AND_REFUND = 'cancel_and_refund';
    const WAIT_TO_PRODUCE = 'waiting_to_produce';
    const PRODUCING = 'producing';
    const SHIPPING = 'shipping';
    const SHIPPED = 'shipped';
    const ARRIVED = 'arrived';

    public static function open() {
        return self::whereName(self::OPEN)->first();
    }

    public function scopeCancel ($query)
    {
        return $query->whereName(self::CANCEL);
    }
    public function scopeProducing ($query)
    {
        return $query->whereName(self::PRODUCING);
    }

    public function scopeStatus ($query, $status_name)
    {
        return $query->whereName($status_name);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
