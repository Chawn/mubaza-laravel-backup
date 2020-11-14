<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserActivate extends Model
{
    public $dates = ['expired_at'];

    public $fillable = [
        'user_id', 'otp', 'expired_at'
    ];

    public static function checkOTP (User $user, $otp)
    {
        $user_activate = $user->user_activates()->where('otp', $otp)->where('expired_at', '<', \Carbon::now())->first();

        if(!$user_activate) {
            return false;
        }

        $user->clearOtp();

        return true;
    }

    public static function createOTP (User $user)
    {
        // Loop random digit for otp
        while(true) {
            $otp = rand(0000, 9999);
            // No otp for all digit
            if ( !in_array($otp, [ 0000, 1111, 2222, 3333, 4444, 5555, 6666, 7777, 8888, 9999 ]) ) {
                break;
            }
        }

        $user_activate = new UserActivate();

        $user_activate->user_id = $user->id;
        $user_activate->otp = $otp;
        $user_activate->expired_at = \Carbon::now()->addMinutes(5);
        if(!$user_activate->save()) {
            return null;
        }

        return $user_activate;
    }
    public function user ()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
