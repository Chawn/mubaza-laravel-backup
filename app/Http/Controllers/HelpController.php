<?php namespace App\Http\Controllers;

use Auth;
use App\User;
use App\UserProfile;
use App\Campaign;
use Request;

class HelpController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     */
    public function get__construct()
    {
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function getIndex()
    {
        return view('help.help_center', [ 'title' => \Lang::get("messages.help_center") ]);
    }

    public function getFaq()
    {
        return view('help.faq', [ 'title' => \Lang::get("messages.faq") ]);
    }

    public function getTerms()
    {
        return view('help.terms', [ 'title' => \Lang::get("messages.terms") ]);
    }

    public function getWarranty()
    {
        return view('help.warranty', [ 'title' => \Lang::get("messages.warranty") ]);
    }

    public function getPrivacy_policy()
    {
        return view('help.privacy_policy', [ 'title' => \Lang::get("messages.privacy_policy") ]);
    }

    public function getPayment_terms()
    {
        return view('help.payment_terms', [ 'title' => \Lang::get("messages.payment_terms") ]);
    }

    public function getOrder_status()
    {
        return view('help.order_status', [ 'title' => \Lang::get("messages.order_status") ]);
    }

    public function getShipping()
    {
        return view('help.shipping', [ 'title' => \Lang::get("messages.shipping") ]);
    }

    public function getContact()
    {
        return view('help.contact', [ 'title' => \Lang::get("messages.contact") ]);
    }

    public function getCareers()
    {
        return view('help.careers', [ 'title' => \Lang::get("messages.careers") ]);
    }

    public function getAbout()
    {
        return view('help.about', [ 'title' => \Lang::get("messages.about") ]);
    }


    public function getCopyright()
    {
        return view('help.copyright', [ 'title' => 'ลิขสิทธิ์' ]);
    }

    public function getHowtobuy()
    {
        return view('help.howtobuy', [ 'title' => 'วิธีการสั่งซื้อ' ]);
    }

    public function getHowtopay()
    {
        return view('help.howtopay', [ 'title' => 'ช่องทางชำระเงิน' ]);
    }
    public function getHowtoshipping()
    {
        return view('help.howtoshipping', [ 'title' => 'การจัดส่ง' ]);
    }
    public function getCoupon()
    {
        return view('help.coupon', [ 'title' => 'คูปองส่วนลด' ]);
    }

    public function getSizing()
    {
        return view('help.sizing', [ 'title' => 'วิธีการวัดขนาดเสื้อ' ]);
    }

    public function getSingup()
    {
        return view('help.singup', [ 'title' => 'การสมัครสมาชิก' ]);
    }

    public function getDesign_buy()
    {
        return view('help.design_buy', [ 'title' => 'ออกแบบเพื่อสั่งซื้อ' ]);
    }

    public function getValue()
    {
        return view('help.value', [ 'title' => 'การสั่งซื้อจำนวนมาก' ]);
    }
    public function getChangeorcancel()
    {
        return view('help.change-or-cancel', [ 'title' => 'การเปลี่ยนแปลง/ยกเลิกการสั่งซื้อ' ]);
    }
}