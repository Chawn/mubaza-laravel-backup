@extends('backend.layouts.email')
@section('content')
	<h3 style="color:#61a9e2;">แคมเปญ {{ $campaign['title'] }} ได้สร้างแล้ว</h3>
	<p><b>สวัสดี</b> {{ $user['full_name'] }}</p>
	<p><b>ก้าวแรกแห่งความสำเร็จของคุณได้เริ่มขึ้นแล้ว&nbsp</b>ขั้นต่อไป เพียงคุณนำลิงก์ด้านล่างนี้ ไปแชร์ผ่านโซเชียลมีเดียต่างๆ คุณก็จะกลายเป็นเจ้าของกิจการโดยที่ไม่ต้องลงทุนใดๆ</p>

	<p><a href="{{ action('SellController@showCampaign', $campaign['url']) }}">{{ action('SellController@showCampaign', $campaign['url']) }}1</a></p>

	<p>พกไอเดียและความตั้งใจมาร่วมกับเรา เราจะเป็นสื่อกลางให้คุณ</p>
	</br>
	<p>ขอบคุณ</p>
	<p>ทีมงาน GGSEVEN</p>
@stop