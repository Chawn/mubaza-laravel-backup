@extends('backend.layouts.email')
@section('content')
	<p><b>สวัสดี&nbsp;</b>คุณ{{ $user['full_name'] }}</p>
    <p>คุณได้ทำการเปลี่ยนอีเมล์ของคุณจาก <strong>{{ $old_email }}</strong>&nbsp;เป็น&nbsp;<strong>{{ $user['email'] }}</strong></p>
	<p>โปรดคลิกที่ลิ้งค์เพื่อดำเนินการเปลี่ยนอีเมล์ให้เสร็จสมบูรณ์</p>
    <p><a href="{{ action('UserController@getConfirmChangeEmail', [$id, $token]) }}">ยืนยันการเปลี่ยนอีเมล์</a></p>
    <br/>
	<p>
		ขอขอบคุณที่ใช้ GGSEVEN หากมีคำถามหรือข้อสงสัยเกี่ยวกับบัญชีของคุณ โปรดเข้าไปที่ศูนย์ช่วยเหลือ ของ {{ config('profile.sitename') }} ได้ที่
	</p>
	<p><a href="{{ action('HelpController@getContact') }}">ติดต่อเรา</a></p>
	<p>นี่เป็นจดหมายสำหรับส่งเพียงอย่างเดียว และจะไม่มีการตรวจสอบหรือตอบกลับจดหมายที่คุณส่งกลับมา</p>
    <br/>
	<p>ขอบคุณ</p>
	<p>ทีมงาน {{ config('profile.sitename') }}</p>
@stop