@extends('backend.layouts.email')
@section('content')
	<p><b>สวัสดี&nbsp</b>ปรียานุช</p>
	<p>บัญชี GGSEVEN ของคุณได้ลบบัญชีธนาคาร 
		<b>1234567890</b> เมื่อ 18 มิถุนายน 2558 เวลา 12:12 น.
	</p>
	</br>
	<p><b>หากคุณได้ดำเนินการ&nbsp</b>คุณสามารถเพิกเฉยต่ออีเมล์นี้ได้อย่างปลอดภัย</p>
	<p><b>หากคุณไม่ได้ดำเนินการ&nbsp</b>
	โปรดคลิกที่ลิ้งค์เพื่อดำเนินการยกเลิกการลบบัญชีธนาคารนี้</p>
	<p><a href="#">asdfghjk;qwewqeq</a></p>
	
	</br>
	<p>
		ขอขอบคุณที่ใช้ GGSEVEN หากมีคำถามหรือข้อสงสัยเกี่ยวกับบัญชีของคุณ โปรดเข้าไปที่ศูนย์ช่วยเหลือ ของ {{ config('profile.sitename') }} ได้ที่
	</p>
	<p><a href="{{ action('HelpController@getContact') }}">ติดต่อเรา</a></p>
	<p>นี่เป็นจดหมายสำหรับส่งเพียงอย่างเดียว และจะไม่มีการตรวจสอบหรือตอบกลับจดหมายที่คุณส่งกลับมา</p>
	</br>
	<p>ขอบคุณ</p>
	<p>ทีมงาน {{ config('profile.sitename') }}</p>
@stop