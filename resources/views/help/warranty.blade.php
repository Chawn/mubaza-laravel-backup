@extends('layouts.help')
@section('css')
<style type="text/css" media="screen">
	
#warranty img {
	width: 80%;
	display: block;
	margin:auto;
}
</style>
@stop
@section('content')
<div id="artcle">
	<div id="warranty">
		<p class="text-indent">
			สิ่งสำคัญและเป็นนโยบายอย่างหนึ่งของมูบาซ่า คือ ความพึงพอใจของลูกค้าต่อสินค้าและบริการของเรา ลูกค้าที่สั่งซื้อสินค้าจาก {{ config('profile.sitename') }} จะได้รับสิทธิและการคุ้มครองจากเรา ดังนี้ 

		</p>
		<h4 class="article-title">1. การเปลี่ยนสินค้า</h4>
		<p class="text-indent">
			เปลี่ยนสินค้าได้ภายใน 10 วัน (นับจากวันที่จัดส่ง) ในกรณีดังต่อไปนี้
			<ol>
				<li>
					ลายไม่สมบูรณ์ มีตำหนิ ขาดหาย 
				</li>
				<li>
					สินค้ามีตำหนิ เสื้อขาด เย็บไม่ตรง 
				</li>
				<li>
					ลายไม่ตรงกับที่สั่ง
				</li>
				<li>
					ได้รับเสื้อผิดไซส์
				</li>
			</ol>
		</p>
		<h4 class="article-title">2. การคืนเงิน</h4>
	
		<p class="text-indent">
			คืนเงินเต็มจำนวน หากคุณไม่ได้รับสินค้านานเกินกว่า 14 วันทำการ นับตั้งแต่วันที่คุณชำระเงิน และตรวจสอบสถานะการจัดส่งผ่านระบบ Tracking ของบริษัทจัดส่ง 
		</p>

		<h4 class="article-title">ติดต่อเรา</h4>
		<p class="text-indent">
			กรุณาส่งคำขอของคุณมาที่ <a href="{{ action('HelpController@getContact') }}">ติดต่อเรา</a> 
		</p>

			
			

			
			
	</div>
</div>
<!-- end PAGE -->
@stop

