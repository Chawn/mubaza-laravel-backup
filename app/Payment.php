<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {

    protected $dates = ['pay_on', 'confirmed_at'];
    public $fillable = [
        'pay_on', 'confirmed_at',
        'transaction_id', 'from_bank', 'to_bank',
        'order_id', 'total', 'slip_upload', 'remark'
    ];

    /**
     * @param $query
     * @return \Illuminate\Database\Query\Builder;
     */
    public function scopeActive ($query)
    {
        return $query->where('is_active', true);
    }


    /**
     * Cancel payment set inactive payment
     * @return bool
     */
    public function cancel ()
    {
        $this->is_active = false;

        return $this->save();
    }

    public function getPayOnDate()
    {
        return explode(' ', $this->pay_on)[0];
    }

    public function getPayOnTime()
    {
        return explode(' ', $this->pay_on)[1];
    }

    public function order() {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function payment_type() {
        return $this->belongsTo('App\PaymentType', 'payment_type_id');
    }
}
