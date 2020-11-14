@extends('manager.layouts.master')
@section('script')

@stop
@section('css')
<style>
	.main{
		padding-top: 0px;
        margin-top:0px;
	}
	#artist-header .jumbotron{
		padding-top: 40px;
	}
	.media-left{
		width: 10%;
	}
	.media-icon{
		font-size: 60px;
	}
	@media(max-width: 767px){
		#artist-header img{
			width: 100%;
		}
		#artist-header .btn{
			width: 100%;
			height: auto;
			font-size: 16px;
		}
	}	
</style>
@stop
@section('content')
<section id="artist-header">
	
		<div class="row">			
			<div class="col-sm-4 col-xs-12 text-center">
				<img src="{{ asset('images/tdesign.png') }}" alt="">
			</div>
			<div class="col-sm-8 col-xs-12">
				<div class=" text-center">
					<h2><strong>Creator คืออะไร ?</strong></h2>
					<h3>
						Creator หมายถึง ผู้ออกแบบและสร้างสินค้า
					</h3>
				</div>
				<br>
				<p class="text-center">
	                <a href="{{ action('AssociateController@getRegister') }}" class="btn btn-xl btn-success">
	                	ลงทะเบียน
	                </a>
				</p><br>
            
			</div>
		</div>
	
</section>
<section id="agreement" class="box">
	<div class="associate-content">
		<div class="media">
			<div class="media-left">
				<a>
					<i class="media-icon fa fa-pie-chart"></i>
				</a>
			</div>
			<div class="media-body">
				<h3 class="text-orange media-heading"><strong>ส่วนแบ่งเริ่มต้นที่ 10% จากราคาขาย </strong></h3>
				<p>ส่วนแบ่งคิดจากราคาสินค้าที่คุณได้ตั้งไว้ เช่น ราคาสินค้า 390 บาท ส่วนแบ่งสำหรับครีเอเตอร์ 10% คุณจะได้รับ 39 บาท ในสินค้าทุกๆ ชิ้นที่ขายได้ หากคุณเป็นผู้ขายเองผ่าน Affiliate Id ของคุณ คุณจะได้รับส่วนแบ่ง 30% ทันที (Affiliate 20% + Creator 10%)</p> 
			</div>
		</div>

		<div class="media">
			<div class="media-left">
				<a>
					<i class="media-icon fa fa-users"></i>
				</a>
			</div>
			<div class="media-body">
				<h3 class="text-orange media-heading"><strong>มี Affiliate ช่วยขาย</strong></h3>
				<p>ไม่ต้องกังวลหากคุณไม่ถนัดด้านการขาย เพราะมีคนอื่นที่ตั้งใจเป็น Affiliate จะทำหน้าที่ประชาสัมพันธ์สินค้าของคุณเอง แค่ออกแบบให้โดยใจลูกค้าก็พอ และหากจะดีกว่านั้นควรหาโอกาสพูดคุยกับ Affiliate เพื่อเข้าใจกลุ่มลูกค้ามากขึ้น
				</p>
			</div>
		</div>
		<div class="media">
			<div class="media-left">
				<a>
					<i class="media-icon fa fa-btc"></i>
				</a>
			</div>
			<div class="media-body">
				<h3 class="text-orange media-heading"><strong>ไม่หักค่าใช้จ่าย</strong></h3>
				<p>คุณจะได้รับส่วนแบ่ง 10% เต็มจำนวนจากราคาขาย ไม่มีการหักต้นทุนสินค้า หรือค่าใช้จ่ายใดๆ ทั้งสิ้น</p>
			</div>
		</div>
		<div class="media">
			<div class="media-left">
				<a>
					<i class="media-icon fa fa-money"></i>
				</a>
			</div>
			<div class="media-body">
				<h3 class="text-orange media-heading"><strong>ไม่มีขั้นต่ำ</strong></h3>
				<p>ไม่ต้องทำยอดให้ถึงเป้าหมาย ขายได้ตัวเดียวก็จ่ายส่วนแบ่งเลย</p>
			</div>
		</div>
		<div class="media">
			<div class="media-left">
				<a>
					<i class="media-icon fa fa-clock-o"></i>
				</a>
			</div>
			<div class="media-body">
				<h3 class="text-orange media-heading"><strong>งานออกแบบไม่มีวันหมดเวลา</strong></h3>
				<p>งานออกแบบของคุณจะอยู่บนเว็บไซต์ของเราตลอดไป ไม่มีวันหมดอายุ </p>
			</div>
		</div>
		<div class="media">
			<div class="media-left">
				<a>
					<i class="media-icon fa fa-flag-o"></i>
				</a>
			</div>
			<div class="media-body">
				<h3 class="text-orange media-heading"><strong>Passive Income</strong></h3>
				<p>งานของคุณจะสร้างรายได้ให้คุณตลอดไป ถึงแม้ว่าคุณจะว่างเว้นจากการอัพเดทสินค้า แต่ถ้าหากมีการซื้อขายสินค้าของคุณเกิดขึ้น คุณก็จะยังได้รับรายได้ต่อไป</p>
			</div>
		</div>
		<div class="media">
			<div class="media-left">
				<a>
					<i class="media-icon fa fa-heart-o"></i>
				</a>
			</div>
			<div class="media-body">
				<h3 class="text-orange media-heading"><strong>ลูกค้าติดตามคุณได้บนเว็บไซต์ (Follow)</strong></h3>
				<p>คุณไม่ต้องกลัวว่าลูกค้าจะไม่รู้จักคุณ เรามีหน้าโปรไฟล์ไว้สำหรับผู้ที่ชื่นชอบผลงานของคุณได้เข้าชม และยังสามารถกดติดตามผลงานของคุณได้ และเมื่อคุณอัพเดทสินค้าใหม่ๆ ทางเราจะแจ้งเตือนไปยังผู้ใช้ที่ได้กดติดตามคุณไว้</p>
			</div>
		</div>
	</div>
</section>
@stop