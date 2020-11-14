<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduceStatus extends Model {

    public $timestamps = false;
    public $fillable = [
        'name', 'detail'
    ];

    public function scopeStatus ($query, $name)
    {
        return $query->whereName($name);
    }
    /**
     * Get approve status
     * @return mixed
     */
    public static function approve()
    {
        return OrderProduceStatus::whereName('approve')->first();
    }
    /**
     * Get waiting status
     * @return mixed
     */
    public static function waiting()
    {
        return OrderProduceStatus::whereName('waiting')->first();
    }
    /**
     * Get producing status
     * @return mixed
     */
    public static function producing()
    {
        return OrderProduceStatus::whereName('producing')->first();
    }

    /**
     * Get shipping status
     * @return mixed
     */
    public static function shipping()
    {
        return OrderProduceStatus::whereName('shipping')->first();
    }

    /**
     * Get shipped status
     * @return mixed
     */
    public static function shipped()
    {
        return OrderProduceStatus::whereName('shipped')->first();
    }

    /**
     * Get cancel status
     * @return mixed
     */
    public static function scopeCancel($query)
    {
        return $query->whereName('cancel');
    }

    public function orders() {
        return $this->hasMany('App\Order');
    }
}
