@extends('backend.layouts.email')
@section('content')
	<h3 style="color:#e67e22;">หมายเลขการสั่งซื้อ {{ str_pad($order_id, 6, 0, STR_PAD_LEFT) }} จัดส่งแล้ว</h3>
	<p><b>สวัสดี</b> {{ $user['full_name'] }}ช</p>
	<p>การสั่งซื้อจากแคมเปญ <a href="{{ action('SellController@showCampaign', $campaign['url']) }}">{{ $campaign['title'] }}</a> ที่คุณสั่งซื้อ ได้จัดส่งเรียบร้อยแล้ว </p>

	<p>tracking no. :&nbsp <b>{{ $tracking_no }}</b> จะใช้เวลาในการจัดส่งไม่เกิน 7 วันทำการ ตามเงื่อนไข<a href="{{ action('HelpController@getShipping') }}">ระยะเวลาผลิตและจัดส่ง</a></p>


	<p>หากไม่ได้รับสินค้าในเวลาหรือมีข้อสงสัย คุณสามารถติดต่อแผนกลูกค้าสัมพันธ์ได้ที่ 098 101 5050, 098 101 6060 วันจันทร์-วันเสาร์ เวลา 09.00 - 19.00 ปิดทำการวันอาทิตย์ และวันหยุดนักขัตฤกษ์ Email:<a href="mailto:{{ config('profile.email') }}">{{ config('profile.email') }}</a>  ศึกษาข้อมูลเงื่อนไขการรับประกันเพิ่มเติมได้ <a href="{{ action("HelpController@getWarranty") }}">ที่นี่</a></p>

	<p>ขอบคุณ</p>
	<p>ทีมงาน GGSEVEN</p>
@stop