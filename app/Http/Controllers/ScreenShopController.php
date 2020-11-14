<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ScreenShopController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        return view('backend.screenshop.index', ['title' => 'หน้าสำหรับรายสกรีน']);
    }

    public function getDetail() {
        return view('backend.screenshop.detail', ['title' => 'รายละเอียดการสั่งซื้อ']);
    }
}
