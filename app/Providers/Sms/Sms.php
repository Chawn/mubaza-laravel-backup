<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 11/26/2015 AD
 * Time: 16:05
 */

namespace App\Providers\Sms;


class Sms
{
    // API Url
    private $url;
    // Username for sms gateware
    private $username;
    // Password for sms gateway
    private $password;
    // Sender name display on mobile phone
    private $sender;
    private $force;
    private $agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4)
Gecko/20030624 Netscape/7.1 (ax)";

    public function __construct ()
    {
        $url = config('sms.url_test');
        $username = config('sms.username');
        $password = config('sms.password');
        $sender = config('sms.sender');
        $force = config('sms.force');
    }

    public function send ($msisdn, $message)
    {
        $parameter = 'username=' . $username;
        $parameter .= '&password=' . $password;
        $parameter .= '&msisdn=' . $msisdn;
        $parameter .= '&message=' .$message;
        $parameter .= '&sender=' . $sender;
        $parameter .= '&force=' . $force;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameter);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        $result = curl_exec ($ch);
        curl_close ($ch);

        dd($result);
    }
}