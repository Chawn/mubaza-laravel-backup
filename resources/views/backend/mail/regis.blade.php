@extends('backend.layouts.email')
@section('content')
	<p><b>สวัสดี</b> คุณ{{ $user['full_name'] }}</p>
	<p>ทาง {{ config('profile.sitename') }} ได้รับคำขอสมัครสมาชิกของคุณ</p>
	<p>โปรดคลิกที่ลิ้งค์เพื่อดำเนินการสมัครสมาชิกให้เสร็จสมบูรณ์</p>
	<p>
		<a href="{{ action('UserController@getComfirmEmail', [$id, $token]) }}">{{ action('UserController@getComfirmEmail', [$user['id'], $token]) }}</a>
	</p>

    <br/>
	<p>ทีมงาน GGSEVEN</p>
@stop