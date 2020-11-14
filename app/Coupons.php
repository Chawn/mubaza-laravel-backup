<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Coupons extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['coupon_condition_end_date', 'deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'coupons';

    protected $fillable = [
        'coupon_name',
        'coupon_detail',
        'coupon_discount_number',
        'coupon_condition_at_least_price_flag',
        'coupon_condition_end_date_flag',
        'coupon_condition_max_use_per_user_flag',
        'coupon_condition_max_user_flag',
        'coupon_condition_at_least_price',
        'coupon_condition_end_date',
        'coupon_condition_max_use_per_user',
        'coupon_condition_max_user',
        'status',
    ];

    public static $insertRules = [
        'coupon_name' => 'required|max:255',
        'coupon_detail' => 'required',
        'coupon_code' => 'required',
        'coupon_discount_number' => 'required|integer',
        'coupon_discount_type' => 'required',
        'coupon_condition_at_least_price' => 'required_with:coupon_condition_at_least_price_flag|integer',
        'coupon_condition_end_date' => 'required_with:coupon_condition_end_date_flag|date',
        'coupon_condition_max_use_per_user' => 'required_with:coupon_condition_max_use_per_user_flag|integer',
        'coupon_condition_max_user' => 'required_with:coupon_condition_max_user_flag|integer',
        'status' => 'required'
    ];

    public static function getAll()
    {
        return DB::table('coupons')
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')
            ->get();
    }

    public static function checkCode($code, $userId, $totalPrice)
    {
        $code = Coupons::sqlInjection($code);
        settype($code, 'string');
        $userId = Coupons::sqlInjection($userId);
        settype($userId, 'integer');
        $totalPrice = Coupons::sqlInjection($totalPrice);
        settype($totalPrice, 'double');

        $sql = "
          SELECT id, coupon_discount_number, coupon_discount_type
            FROM coupons
            WHERE binary coupon_code = '%s'
            AND
                coupons.status = 'enable'
            AND
                coupons.deleted_at IS NULL
            AND
                -- Algorithm limitation of end date
                IF(coupon_condition_end_date_flag = 'yes', CURRENT_TIMESTAMP, 0)  <=
                    IF(coupon_condition_end_date_flag = 'yes', coupon_condition_end_date, 0)
            AND
                --  Algorithm limitation of useing per user
                IF(coupon_condition_max_use_per_user_flag = 'yes', coupon_condition_max_use_per_user, 1) >
                    IF(coupon_condition_max_use_per_user_flag = 'yes',
                        (SELECT count(*) FROM redeem_coupons
                            WHERE redeem_coupons.coupon_id =  coupons.id AND
                            redeem_coupons.user_id = %d AND
                            redeem_coupons.redeem_status = 'success'), 0)
            AND
                -- Algorithm limitation of max users
                IF(coupon_condition_max_user_flag = 'yes' AND
                    (SELECT count(*) FROM redeem_coupons
                            WHERE redeem_coupons.coupon_id =  coupons.id AND
                            redeem_coupons.user_id = %d AND
                            redeem_coupons.redeem_status = 'success') = 0
                    , coupon_condition_max_user, 1) >
                    IF(coupon_condition_max_user_flag = 'yes' AND
                      (SELECT count(*) FROM redeem_coupons
                            WHERE redeem_coupons.coupon_id =  coupons.id AND
                            redeem_coupons.user_id = %d AND
                            redeem_coupons.redeem_status = 'success') = 0
                        ,
                        (SELECT count(*) FROM redeem_coupons
                            WHERE redeem_coupons.coupon_id =  coupons.id AND
                            redeem_coupons.redeem_status = 'success'), 0)
            AND
                -- Algorithm limitation of at least total price.
                IF(coupon_condition_at_least_price_flag = 'yes', coupon_condition_at_least_price, %d ) <= %d ";

        $sql = sprintf($sql, $code, $userId, $userId, $userId, $totalPrice, $totalPrice);
        return DB::select($sql);
    }

    public function getStatusName ()
    {
        if($this->status == 'enable') {
            return 'เปิดใช้งาน';
        } else if($this->status == 'draft') {
            return 'ฉบับร่าง';
        } else if($this->status == 'disable') {
            return 'ปิดการใช้งาน';
        } else {
            return '';
        }
    }
    public static function sqlInjection($variable)
    {
        $variable = strip_tags(trim($variable));
        return $variable;
    }

    public function redeemed()
    {
        return $this->hasMany(redeem_coupons::class, 'coupon_id');
    }
}
