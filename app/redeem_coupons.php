<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class redeem_coupons extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'redeem_coupons';

    public static function findByCouponId($id)
    {
        return redeem_coupons::where('coupon_id', $id)
            ->orderBy('id', 'desc');
    }

    public static function useCoupon($couponId, $userId, $orderId, $redeemStatus, $clientIP)
    {
        $redeemCoupon = new redeem_coupons;
        $redeemCoupon->coupon_id = $couponId;
        $redeemCoupon->user_id = $userId;
        $redeemCoupon->order_id = $orderId;
        $redeemCoupon->redeem_status = $redeemStatus;
        $redeemCoupon->session_info = json_encode(array('ip' => $clientIP, 'request_data' => $_REQUEST, 'session_info' => $_SERVER));
        $redeemCoupon->created_at = time();
        $redeemCoupon->updated_at = time();
        return $redeemCoupon->save();
    }

    public static function getClientIP()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
