@extends('backend.layouts.email')
@section('content')
	<h3 style="color:#e67e22;">แคมเปญที่คุณสั่งซื้อไม่ได้รับการผลิต</h3>
	<p><b>สวัสดี</b> {{ $user['full_name'] }}</p>
	<p>แคมเปญ <a href="{{ action('SellController@showCampaign', $campaign['url']) }}">{{ $campaign['title'] }}</a> ที่คุณสั่งซื้อในรหัสการสั่งซื้อ {{ str_pad($order['id'], 6, 0, STR_PAD_LEFT) }} ไม่ถึงเป้าหมายที่กำหนดและไม่ได้รับการผลิต</p>

	<p>ทางเรากำลังดำเนินการตรวจสอบการสั่งซื้อและการคืนเงิน(กรณีโอนเงิน) กรุณาคลิกที่ลิงก์ด้านล่างเพื่อดำเนินการขอคืนเงิน </p>
	<p><a href="{{ action('SellController@getRefund', $order['id']) }}">{{ action('SellController@getRefund', $order['id']) }}</a></p>
	<p>หรือดำเนินการยกเลิกการตัดยอดจากบัตรเครดิต(กรณีชำระเงินผ่านบัตรเครดิต)</p>

	<p>หากมีข้อสงสัย คุณสามารถติดต่อแผนกลูกค้าสัมพันธ์ได้ที่ 098 101 5050, 098 101 6060 วันจันทร์-วันเสาร์ เวลา 09.00 - 19.00 ปิดทำการวันอาทิตย์ และวันหยุดนักขัตฤกษ์ Email:<a href="{{ config('profile.email') }}">{{ config('profile.email') }}</a>  ศึกษาข้อมูลเงื่อนไขการรับประกันเพิ่มเติมได้ <a href="{{ action('HelpController@getWarranty') }}">ที่นี่</a></p>

	<p>ขอบคุณ</p>
	<p>ทีมงาน GGSEVEN</p>
@stop