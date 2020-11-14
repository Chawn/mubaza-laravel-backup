@extends('layouts.help')
@section('css')
<style>
	img {
		width: 100%;
		
	}
</style>
@stop
@section('content')
<div id="artcle">
	<p class="text-indent">
		สร้างบัญชีบน MUBAZA 
  คุณสามารถสร้างบัญชีบนมูบาซ่าได้อย่างง่ายดายเพียงคุณมีอีเมลดังนี้ 
	</p>
	<p class="text-indent">
		<ol>
			<li>คลิกเข้าสู่ระบบ
			 <img src="{{asset('images/howto/clicklogin.png')}}">
			</li>
			<li>เลือกสมัครสมาชิกด้วยอีเมล์
			 <img src="{{asset('images/howto/choosesingup.png')}}">
			</li>
			<li>กรอกข้อมูลให้ครบถ้วน แล้วคลิกปุ่มสมัครสมาชิก 
			 <img src="{{asset('images/howto/singupdetail.png')}}">
			</li>
		</ol>
	</p>
	<p class="text-indent">
		หรือหากคุณต้องการลงชื่อเข้าใช้ด้วยบัญชี  Facebook, Google+, Tweeter ของคุณ 
		คุณก็สามารถใช้บัญชี Facebook, google+ Tweeter ของคุณที่มีอยู่ในการลงชื่อเข้าใช้มูบาซ่าได้อย่างรวดเร็ว 
		เพียงกดลงชื่อเข้าใช้ เลือกบัญชีที่คุณต้องการใช้ในการลงชื่อเข้าใช้ จากนั้นกดยืนยัน 
		<img src="{{asset('images/howto/loginwith.png')}}">
	</p>
</div>
<!-- end PAGE -->
@stop