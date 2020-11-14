@extends('backend.layouts.email')
@section('content')
	<h3 style="color:#82bc00;">GGSEVEN คืนเงินแล้ว</h3>
	<p><b>สวัสดี</b> {{ $user['full_name'] }}</p>
	<p>จากแคมเปญ <a href="{{ action('SellController@showCampaign', $campaign['url']) }}">{{ $campaign['title'] }}</a> ที่คุณสั่งซื้อ ไม่ได้รับการผลิตนั้น ทางเราได้ตรวจสอบการคืนเงินและได้อนุมัติคืนเงินจำนวน<b>123 บาท</b>เป็นที่เรียบร้อยแล้ว</p>

	<p>หากมีข้อสงสัย คุณสามารถติดต่อแผนกลูกค้าสัมพันธ์ได้ที่ 098 101 5050, 098 101 6060 วันจันทร์-วันเสาร์ เวลา 09.00 - 19.00 ปิดทำการวันอาทิตย์ และวันหยุดนักขัตฤกษ์ Email:<a href="{{ config('profile.email') }}">{{ config('profile.email') }}</a>  ศึกษาข้อมูลเงื่อนไขการรับประกันเพิ่มเติมได้ <a href="{{ action('HelpController@getWarranty') }}">ที่นี่</a></p>

	<p>ขอบคุณ</p>
	<p>ทีมงาน GGSEVEN</p>
@stop