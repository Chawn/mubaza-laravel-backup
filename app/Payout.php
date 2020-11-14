<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payout extends Model
{

    use SoftDeletes;
    public $dates = [ 'start', 'end', 'pay_on' ];

    public $fillable = [
        'user_id',
        'total',
        'pay_total',
        'return_total',
        'transfer_fee',
        'start',
        'end',
        'from_bank',
        'bank_id',
        'bank_name',
        'bank_account_name',
        'pay_on',
        'payout_status_id'
    ];

    public function scopeApproved ($query)
    {
        return $query->where('payout_status_id', PayoutStatus::approved()->first()->id);
    }
    public function scopePaid ($query)
    {
        return $query->where('payout_status_id', PayoutStatus::paid()->first()->id);
    }

    public function status ()
    {
        return $this->belongsTo('App\PayoutStatus', 'payout_status_id');
    }

    public function monthly_commissions ()
    {
        return $this->hasMany(MonthlyCommission::class);
    }

    public function user ()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
