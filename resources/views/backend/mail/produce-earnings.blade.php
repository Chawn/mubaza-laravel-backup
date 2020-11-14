@extends('backend.layouts.email')
@section('content')
	<h3 style="color:#61a9e2;">แคมเปญ {{ $campaign['title'] }} ได้รับการผลิต</h3>
	<p><b>สวัสดี</b> {{ $user['full_name'] }}</p>

	<p>คลิกที่ลิก์ด้านล่างนี้ เพื่อกรอกข้อมูล รับรายได้จากความสำเร็จในครั้งนี้</p>

	<p><a href="{{ action('UserController@getFinance', $id) }}">ดูรายละเอียด</a></p>
    <br/>
	<p>ทางเรายินดีเป็นอย่างยิ่งสำหรับความสำเร็จในครั้งนี้และหวังเป็นอย่างยิ่งว่าคุณจะสร้างความสำเร็จในครั้งต่อไปได้เพิ่มมากขึ้นเรื่อยๆ</p>
	<p>ขอบคุณ</p>
	<p>ทีมงาน GGSEVEN</p>
@stop