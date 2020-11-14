@extends('backend.layouts.email')
@section('content')
	<p><b>สวัสดี</b> {{ $user['full_name'] }}</p>
	<p>เราขอแจ้งให้ทราบว่าเนื่องจากคุณละเมิดข้อตกลงการใช้งาน (<a href="{{ action('HelpController@getTerms') }}">{{ action('HelpController@getTerms') }}</a>) ของเราอย่างรุนแรงหรือหลายครั้ง บัญชีผู้ใช้ GGSEVEN ของคุณจึงถูกระงับไว้ชั่วคราว หลังจากตรวจสอบแล้ว พบว่าบัญชีของคุณละเมิดข้อตกลงการใช้งาน  {{ $user['remark'] }}</p>
	<p>โปรดทราบว่าคุณไม่ได้รับอนุญาตให้เข้าถึง ครอบครอง หรือสร้างบัญชี GGSEVEN อื่นใด สำหรับข้อมูลเพิ่มเติมเกี่ยวกับการยุติการใช้งานบัญชีและการบังคับใช้ข้อตกลงการใช้งานของเรา โปรดไปที่ศูนย์ช่วยเหลือของเรา</p>
	<p><a href="{{ action('HelpController@getTerms') }}">{{ action('HelpController@getTerms') }}</a></p>
@stop