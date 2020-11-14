@extends('backend.layouts.email')
@section('content')
    <p><b>สวัสดี</b> {{ $user['full_name'] }}</p>
    <p>ผู้ใช้ <a href="{{ action('UserController@getProfile', $creator['id']) }}">{{ $creator['full_name'] }}</a>
        ที่คุณติดตาม ได้สร้างแคมเปญใหม่ คลิกที่ลิงก์ด้านล่าง เพื่อดูหรือเลือกซื้อ</p>
    <p>
        <a href="{{ action('SellController@showCampaign', $campaign['url']) }}">{{ action('SellController@showCampaign', $campaign['url']) }}</a>
    </p>

    <p>ทีมงาน GGSEVEN</p>
@stop