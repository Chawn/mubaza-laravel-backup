@extends('backend.layouts.email')
@section('content')
	<h3 style="color:#82bc00;">แคมเปญที่คุณสั่งซื้อได้รับการผลิต</h3>
	<p><b>สวัสดี</b> {{ $user['full_name'] }}</p>
	<p>แคมเปญ <a href="{{ action('SellController@showCampaign', $campaign['url']) }}">{{ $campaign['title'] }}</a> ที่คุณสั่งซื้อ ได้รับการผลิต กระบวนการผลิตและจัดส่งจะใช้เวลา<b>ไม่เกิน 14 วันทำการ</b> (ศึกษาเพิ่มได้ที่&nbsp;<a href="{{ action('HelpController@getShipping') }}">ระยะเวลาผลิตและจัดส่ง</a>)</p>

	<p>หากไม่ได้รับสินค้าในช่วงเวลาดังกล่าว กรุณาแจ้งแผนกลูกค้าสัมพันธ์ได้ที่ 098 101 5050, 098 101 6060 วันจันทร์-วันเสาร์ เวลา 09.00 - 19.00 ปิดทำการวันอาทิตย์ และวันหยุดนักขัตฤกษ์ Email:<a href="mailto:{{ config('profile.email') }}">{{ config('profile.email') }}</a>  ศึกษาข้อมูลเงื่อนไขการรับประกันเพิ่มเติมได้ <a href="{{ action('HelpController@getWarranty') }}">ที่นี่</a></p>

	<p>ขอบคุณ</p>
	<p>ทีมงาน GGSEVEN</p>
@stop