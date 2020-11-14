@extends('layouts.help')
@section('css')
<style>
.step-list img{
	width: 100%;
}
.step-list li{
	padding-bottom: 20px;
}
.step-list img.screen {
	margin-top: 5px;
	  border: solid 20px #222;
	  border-radius: 15px 15px 5px 5px ;
}
.step-list h2{
	margin-left: -30px;
}
</style>
@stop
@section('content')
<div id="artcle">
	<h4 class="article-title">ออกแบบเพื่อสั่งซื้อ คืออะไร ?</h4>
	คือการสั่งซื้อเสื้อสกรีนตามแบบที่คุณต้องการ ด้วยระบบออกแบบบนเว็บของเรา

	<h4 class="article-title"> ขั้นตอนการออกแบบเพื่อสั่งซื้อ </h4>
	
	<p class="text-indent">
		<ul class="list-unstyled step-list">
			<li><h2>1. ออกแบบ</h2>
				<img class="screen" src="{{asset('images/howto/design/design1.jpg')}}">
			</li>
			<li><h2>2. เลือกขนาดและจำนวน</h2>
				<img class="screen" src="{{asset('images/howto/design/design2.jpg')}}">
			</li>
			<li><h2>3. กรอกข้อมูลการจัดส่ง</h2>
				<img class="screen" src="{{asset('images/howto/design/design3-1.jpg')}}">
				<br><br>
				เลือกวิธีการจัดส่ง และวิธีการชำระเงิน
				<img class="screen" src="{{asset('images/howto/design/design3-2.jpg')}}">
			</li>
			<li><h2>4. ชำระเงิน หรือแจ้งชำระเงิน</h2>
				
				หากเลือก "โอนเงินผ่านธนาคาร" ในขั้นตอนที่ 3  เมื่อโอนเงินแล้ว คุณต้องมาแจ้งชำระเงินเพื่อเสร็จสิ้นการสั่งซื้อ
				<img class="screen" src="{{asset('images/howto/design/design4-1.jpg')}}">
				<br><br>
				หากคุณเลือก "จ่ายเงินผ่านบัตรเครดิต/เดบิต" คุณสามารถกรอกข้อมูลบัตรเครดิตเพื่อสั่งซื้อได้เลย
				<img class="screen" src="{{asset('images/howto/design/design4-2.jpg')}}">

			</li>
		</ul>
	</p>
	<hr>
	<div class="text-center">
		<a href="{{ url('design') }}" class="btn btn-primary  btn-lg">ออกแบบเพื่อสั่งซื้อ
		</a>
	</div>
	
</div>
<!-- end PAGE -->
@stop