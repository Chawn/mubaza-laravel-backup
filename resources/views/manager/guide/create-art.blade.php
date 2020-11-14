@extends('manager.layouts.master')

@section('css')
<style>
	.media-img{
		width: 100%;
	}
	ol li {
		line-height: 30px;
	}
</style>
@stop
@section('script')
<script>
	$(document).ready(function() {
		$("#a-caution").click(function() {
		    $('html,body').animate({
		        scrollTop: $("#caution").offset().top-80},
		        'slow');
		});
	});
</script>
@stop
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				1. การออกแบบลายเสื้อ
			</div>
			<div class="panel-body">
				<div class="detail">
					<ol>
						<li>
							เข้าสู่ระบบ Associate
						</li>
						<li>
							<p>เลือกเมนูการออกแบบ จะเห็นเมนูย่อย ดาวโหลด Art Template (เทมเพลตสำหรับออกแบบลายเสื้อ)</p>
							<img class="media-img" src="{{asset('images/guide/create-art/howtocreat-01-download-arttemplate.jpg')}}">
							<p>หรือเข้าไปที่ สร้างสินค้าใหม่ >  อัพโหลดลายเสื้อ เพื่อดาวโหลด Art Template (เทมเพลตสำหรับออกแบบลายเสื้อ) </p>
							<img class="media-img" src="{{asset('images/guide/create-art/howtocreat-01-download.jpg')}}">
						</li>
						<li>
							เปิดเทมเพลตที่ได้ขึ้นมา ด้วยโปรแกรม Photoshop แล้วออกแบบบนไฟล์นั้น<span class="text-red">และต้องจัดวางในตำแหน่งที่จะใช้พิมพ์จริง</span> โปรดศึกษา  <a id="a-caution" href="#caution">ข้อควรระวัง</a> ในการออกแบบ
							<p>
								<b>สำหรับท่านที่ไม่ถนัด Photoshop </b>คุณสามารถออกแบบลายได้บนโปรแกรมที่คุณถนัด ไม่ว่าจะเป็น Illustrator หรือโปรแกรมอื่น ๆ แต่ต้องมีขนาดตามที่เรากำหนด และเป็นภาพที่ใช้พร้อมพิมพ์
							</p>
							<img class="media-img" src="{{asset('images/guide/create-art/howtocreat-02-mockup-art.jpg')}}">
						</li>
						<li>
							บันทึกเป็น .png และขนาดไฟล์ต้องไม่เกิน 5mb
						</li>
					</ol>
				</div>
				<div id="caution" class="detail">
					<div class="page-header">
					  	<h4>ข้อควรทราบ</h4>
					</div>
					<ul>
						<li>
							เราจะใช้รูปภาพนี้ในการพิมพ์ลายบนเสื้อ รูปภาพนี้ต้องไม่มีรูปอื่น ๆ นอกจากลายที่จะพิมพ์
						</li>
						<li>
							ภาพต้องมีขนาด กว้าง 2400 px สูง 3200 px เท่านั้น และ Resolution ไม่ต่ำกว่า 300 (แนะนำที่ 300)
						</li>
						<li>
							ควรทำพื้นหลัง เป็น transparent (โปร่งใส) เพื่อเวลานำไปวางในเทมเพลต และเวลาพิมพ์ในเสื้อจริง จะได้ค่าที่ถูกต้อง หรือหากคุณต้องการใส่พื้นหลังให้กับลายที่คุณออกแบบ ก็สามารถทำได้เช่นกัน
						</li>
						<li>
							ตำแหน่งของลายที่ออกแบบควรเป็นตำแหน่งเดียวกันกับที่ต้องการให้พิมพ์บนเสื้อ เช่น ต้องการวางลายเสื้อที่ตำแหน่งหน้าอกซ้าย คุณต้องสร้างไฟล์ที่มีขนาด 2400 px * 3200 px Resolution 300 พื้นหลัง transparent ขึ้นมาก่อน แล้วออกแบบลายที่คุณต้องการ ให้อยู่ตำแหน่งมุมบนขวา เพื่อให้ภาพพิมพ์อยู่บนซ้ายของเสื้อ แล้วบันทึกไฟล์เป็น .png เพื่อจำนำไปใช้ในการสร้างเป็นภาพตัวอย่างในขั้นตอนถัดไป
						</li>
					</ul>
				</div>				
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				2. การสร้างตัวอย่างเสื้อ
			</div>
			<div class="panel-body">
				
				<div class="detail">
					<ol>
						<li>
							เข้าสู่ระบบ Associate
						</li>
						<li>
							<p>เลือกเมนูการออกแบบ จะเห็นเมนูย่อย ดาวโหลด Art Template (เทมเพลตสำหรับออกแบบลายเสื้อ)</p>
							<img class="media-img" src="{{asset('images/guide/create-art/howtocreat-01-download-mockuptemplate.jpg')}}">
							<p>หรือเข้าไปที่ สร้างสินค้าใหม่ >  อัพโหลดรูปเสื้อเสื้อ เพื่อดาวโหลด Mockup Template (เทมเพลตสำหรับทำตัวอย่างเสื้อ)</p>
							<img class="media-img" src="{{asset('images/guide/create-art/howtocreat-02-download-mockuptemplate.jpg')}}">
						</li>
						<li>
							เปิดไฟล์ เทมเพลต .psd ที่ได้ดาวโหลดไว้ ขึ้นมา
						</li>
						<li>
							นำรูปที่คุณออกแบบไว้ในขั้นตอนที่ 1 มาวางแทนตำแหน่ง ART HERE
							<img class="media-img" src="{{asset('images/guide/create-art/howtocreat-03-mockup.jpg')}}">
						</li>
						<li>
							คุณสามารถเลือกสีเสื้อได้จากโฟลเดอร์ T-shirt Colours
						</li>
						<li>
							บันทึกไฟล์รูปตัวอย่างเสื้อ เป็น .png หรือ jpg ก็ได้ โดยที่คุณไม่ต้องปรับขนาดใด ๆ
						</li>
					</ol>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				3. การสร้างสินค้า
			</div>
			<div class="panel-body">
				<div class="caption">
					<ol>
						<li>
							เข้าสู่ระบบ Associate
						</li>
						<li>
							<p>เลือกเมนูการออกแบบ จะเห็นเมนูย่อย สร้างสินค้าใหม่</p>
							<img class="media-img" src="{{asset('images/guide/create-art/howtocreat-03-newproduct.jpg')}}">
						</li>
						<li>
							ที่ส่วน อัพโหลดลายเสื้อ ให้คุณคลิกที่ปุ่ม อัพโหลดลายเสื้อ > เลือกลายเสื้อที่คุณออกแบบไว้ในขั้นตอนที่ 1  รอจนอัพโหลเสร็จ แล้วกดต่อไป
							<img class="media-img" src="{{asset('images/guide/create-art/howtocreat-04-uploadart.jpg')}}">
						</li>
						<li>
							ที่ส่วน อัพโหลดรูปเสื้อ ให้คุณคลิกที่ปุ่ม อัพโหลดรูปเสื้อเสื้อ > เลือกตัวอย่างเสื้อเสื้อที่คุณได้สร้างไว้ในขั้นตอนที่ 2
								<ul>
									<li>
										เลือกแบบเสื้อที่คุณต้องการขาย
									</li>
									<li>
										เสือกสีเสื้อให้ตรงกับตัวอย่างเสื้อที่คุณได้อัพโหลด
									</li>
									<li>
										กำหนดราคาที่คุณต้องการขาย
									</li>
									<li>
										จากนั้น กดต่อไป
									</li>
								</ul>
							<img class="media-img" src="{{asset('images/guide/create-art/howtocreat-05-uploadmockup.jpg')}}">
						</li>
						<li>
							ที่ส่วน ใส่รายละเอียด ให้คุณ
							<ul>
								<li>
									ใส่ชื่อที่คุณต้องการ
								</li>
								<li>
									เลือกหมวดหมู่
								</li>
								<li>
									ใส่รายละเอียดต่างๆ
								</li>
								<li>
									ใส่แท็ก
								</li>
								<li>
									หากต้องการกำหนดวันขาย หรือจำนวนการขาย ให้เลือกกำหนดวันสิ้นสุด
								</li>
								<li>
									จากนั้น กดฉันได้อ่านและยอมรับข้อตกลงการใช้งาน  
								</li>
								<li>
									กดต่อไป เป็นอันเสร็จสิ้นการสร้าง
								</li>
							</ul>
							<img class="media-img" src="{{asset('images/guide/create-art/howtocreat-06-detail.jpg')}}" alt="">
						</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
