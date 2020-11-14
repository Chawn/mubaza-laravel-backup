@extends('layouts.help')
@section('css')
<style>
	.cr{
		margin-top: 15px;
		width: 100%;
		background: #ccc;
		padding: 25px 0 ;
		text-indent: 0!important;
	}
	img {
		max-width: 80%;
		
	}
</style>
@stop
@section('content')
<div id="artcle">
	
	
	<h4 class="article-title">ที่มาของชื่อ</h4>
	
<p class="text-indent">"MUBAZA" (มูบาซ่า) เป็นชื่อที่นำคำมาจาก MUFASA เป็นชื่อตัวละครจากแอนิเมชันเรื่อง The Lion King 
ในสมัยเด็กๆ ผู้ก่อตั้ง ชื่นชอบและประทับใจแอนิเมชันเรื่อง The Lion King เป็นอย่างมาก ดูหลายครั้งจนสามารถจำท่องบทพูดตามตัวละครได้ขึ้นใจ ตัวละครที่โดดเด่นที่จะไม่พูดถึงไม่ได้ก็คือ มูฟาซ่าผู้เป็นราชาและเป็นพ่อของสิงโตน้อยซิมบ้า มูฟาซ่าจะคอยพรำสอนลูกเกี่ยวกับการเป็นผู้นำที่ดี แม้ในยามที่เขาจากไปคำสอนก็ยังตราตรึงใจซิมบ้าเสมอมา</p>



	<h4 class="article-title">ทะเบียนพาณิชย์</h4>
	<p class="text-indent">{{ config('profile.sitename') }} ได้เปิดตัวอย่างเป็นทางการในวันที่ 10 กรกฎาคม 2558 และจดทะเบียนพาณิชย์อย่างถูกต้องตามกฎหมายในชื่อ "มูบาซ่า" โดยนายชาวพุทธ นวกาลัญญู ทะเบียนพาณิชย์เลขที่ 1411700196868 
	</p>
	<p class="cr text-center">
		<img src="{{asset('images/about/1.JPG')}}">
	</p>
		
	
</div>
<!-- end PAGE -->
@stop

