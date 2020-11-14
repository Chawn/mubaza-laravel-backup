@extends('backend.layouts.email')
@section('content')
	<h3 style="color:#82bc00;">มีคนต้องการขอให้คุณเปิดแคมเปญอีกครั้ง</h3>
	<p><b>สวัสดี</b> {{ $user['full_name'] }}</p>
	<p>เราขอแจ้งให้ทราบว่าเนื่องจาก แคมเปญ<a href="{{ action('SellController@showCampaign', $campaign['url']) }}">{{ $campaign['title'] }}</a> ของคุณ ได้ถูกร้องขอให้เปิดแคมเปญนี้อีกครั้ง คลิกที่ลิงก์ด้านล่างนี้เพื่อดำเนินการเปิดแคมเปญอีกครั้ง</p>
	<p><a href="{{ action('HelpController@getTerms') }}">{{ action('HelpController@getTerms') }}</a></p>

    <br/>
	<p>ทีมงาน GGSEVEN</p>
@stop