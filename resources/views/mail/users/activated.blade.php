@extends('mail.layouts.email-page')
@section('content')
<table style="width: 100%;padding:25px;">
	<tr>
		<td width="25%" style="color:#5eba1c;height:50px;padding:0 25px;">				
			<a href="{{url('/')}}" style="color:#000;text-decoration:none;">
				<img src="{{asset('images/logo-gg7.png')}}" alt="GG7logo" style="height:40px;">
				<p>www.ggseven.com</p>
			</a>
		</td>
		<td width="75%">
			<h1 style="margin: 0px;color:#0096ff" >การสมัครสมาชิกของคุณเสร็จสมบูรณ์</h1>
			<h4>ยินดีต้อนรับสู่ GG7 แบรนเสื้อยืดแฟชั่น หลากหลายทุกความต้องการ</h4>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding:25px;font-size:14px;">
			<p><b>สวัสดี</b> {{ $name }}</p>
			<p>ขณะนี้ คุณสามารถลงชื่อเข้าใช้ที่เว็บไซต์ <a href="{{ url('/') }}">http://www.ggseven.com</a> ได้แล้ว</p>
			<p>ขอขอบคุณ</p>
			<p>ทีมงาน GG7</p>
		</td>
	</tr>
</table>
@stop