<?php
namespace App\Providers\Mail;
use App\User;

/**
 * Created by PhpStorm.
 * User: execter
 * Date: 11/30/2015 AD
 * Time: 10:31
 */
class SendMail
{
    function __construct() {

    }

    /**
     * Send email for activate new account
     * @param User $user
     * @param      $token
     * @return bool
     */
    public function sendConfirmRegistration(User $user, $token) {
        if($token == '') {
            return false;
        }

        if(!$user) {
            return false;
        }

        if(!$user->inActive()) {
            return false;
        }

        \Mail::send('mail.users.confirm', [
            'id' => $user->id,
            'name' => $user->full_name,
            'token' => $token
        ], function($mail) use($user) {
            $mail->to($user->email, $user->full_name)->subject('ขอบคุณสำหรับการสมัครสมาชิก กรุณายืนยันการสมัครสมาชิก');
        });
    }

    public function sendActivatedUser(User $user) {
        if(!$user) {
            return false;
        }

        if($user->inActive()) {
            return false;
        }

        \Mail::send('mail.users.activated', [
            'name' => $user->full_name
        ], function($mail) use($user) {
            $mail->to($user->email, $user->full_name)->subject('การสมัครสมาชิกสำเร็จแล้ว');
        });
    }

    public function  sendReminderEmail(User $user, $token)
    {
        if($token == '') {
            return false;
        }

        \Mail::send('mail.users.forgot-password', [
            'id' => $user->id,
            'name' => $user->full_name,
            'token' => $token
        ], function($mail) use($user) {
            $mail->to($user->email, $user->full_name)->subject('ยืนยันเพื่อกู้คืนรหัสผ่าน');
        });

        return true;
    }
}