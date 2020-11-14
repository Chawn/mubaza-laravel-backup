@extends('backend.layouts.email')
@section('content')
	<p><b>สวัสดี</b> คุณ{{ $user['full_name'] }}</p>
	<p>ยินดีต้อนรับสู่ {{ config('profile.sitename') }}</p>

	<p>ชื่อที่ใช้ในการสมัครของคุณคือ : {{ $user['full_name'] }}</p>
	<p>อีเมล์ : {{ $user['email'] }}</p>
	<p>ขณะนี้ คุณสามารถลงชื่อเข้าใช้ที่เว็บไซต์ <a href="{{ url('/') }}">GGSEVEN</a> ได้แล้ว</p>
	<p>โปรดเก็บรหัสนี้เป้นความลับเพื่อความปลอดภัยของบัญชีของคุณ</p>
	<p>ทีมงาน GGSEVEN</p>
@stop