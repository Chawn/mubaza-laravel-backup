@extends('backend.layouts.email')
@section('content')
	<h3 style="color:#82bc00;">แคมเปญที่คุณร้องขอให้เปิดอีกครั้ง ได้เปิดการขายแล้ว</h3>
	<p><b>สวัสดี</b> {{ $user['full_name'] }}</p>
	<p>เราขอแจ้งให้ทราบว่าแคมเปญ<a href="{{ action('SellController@showCampaign', $campaign['url']) }}">{{ $campaign['title'] }}</a> ที่คุณ ได้ร้องขอให้เปิดแคมเปญนี้อีกครั้งนั้น ได้ทำการเปิดขายอีกครั้งแล้ว คลิกที่ลิงก์ด้านล่างนี้เพื่อสั่งซื้อแคมเปญนี้</p>
	<p><a href="{{ action('HelpController@getTerms') }}">{{ action('HelpController@getTerms') }}</a></p>
	<br />
	<p>ทีมงาน GGSEVEN</p>
@stop