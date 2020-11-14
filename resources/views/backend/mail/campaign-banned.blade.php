@extends('backend.layouts.email')
@section('content')
	<p><b>สวัสดี</b> {{ $user['full_name']}}</p>
	<p>เราขอแจ้งให้ทราบว่าเนื่องจาก แคมเปญ<a href="{{ action('SellController@showCampaign', $campaign['url']) }}">{{ $campaign['title'] }}</a> ของคุณ ได้ถูกแจ้งว่าละเมิดข้อตกลงการใช้งาน (<a href="{{ action('HelpController@getTerms') }}">{{ action('HelpController@getTerms') }}</a>) ของเรา และทางเราขอแจ้งการ<u>ยุติแคมเปญนี้อย่างถาวร</u></p>
	<p>สำหรับข้อมูลเพิ่มเติมเกี่ยวกับการยุติการใช้งานแคมเปญและการบังคับใช้ข้อตกลงการใช้งานของเรา โปรดไปที่ศูนย์ช่วยเหลือของเรา</p>
	<p><a href="{{ action('HelpController@getTerms') }}">{{ action('HelpController@getTerms') }}</a></p>
@stop