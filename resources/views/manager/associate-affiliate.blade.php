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
<section id="artist-header" class="">
	<div class="row">	
		<div class="col-sm-4 col-xs-12 text-center pull-right">
			<img src="{{ asset('images/associate/advertise2.png') }}">
		</div>		
		<div class="col-sm-8 col-xs-12">
			<div class=" text-center">
				<h2><strong>Affiliate คืออะไร ?</strong></h2>
				<h3>
					Affiliate หมายถึง ผู้ทำหน้าที่ประชาสัมพันธ์สินค้า
				</h3>
			</div>
			<br>
			<p class="text-center">
                <a href="{{ action('AssociateController@getRegister') }}" class="btn btn-xl btn-success">
                ลงทะเบียน
                </a>
            </p>
            <br>
		</div>
		
	</div>
</section>
<section id="agreement" class="box">
	<div class="associate-content">
		<div class="media">
			<div class="media-left">
				<a>
					<i class="media-icon fa-3x fa fa-pie-chart"></i>
				</a>
			</div>
			<div class="media-body">
				<h3 class="text-orange media-heading"><strong>ส่วนแบ่งเริ่มต้นที่ 20% จากราคาขาย </strong></h3>
					<p>ส่วนแบ่งของคุณคิดจากราคาสินค้าที่คุณได้ตั้งไว้ เช่น ตั้งไว้ 390 บาท ส่วนแบ่งของคุณ 20% คุณจะได้รับ 78 บาท ในสินค้าทุกๆ ชิ้นที่ขายได้</p>
			</div>
		</div>
		<div class="media">
			<div class="media-left">
				<a>
					<i class="media-icon fa-3x fa fa-btc"></i>
				</a>
			</div>
			<div class="media-body">
				<h3 class="text-orange media-heading"><strong>ไม่หักค่าใช้จ่าย</strong></h3>
				<p>ส่วนแบ่งคำนวณจากราคาขาย ไม่มีการหักต้นทุนสินค้า หรือค่าใช้จ่ายใดๆ ทั้งสิ้น</p>
			</div>
		</div>
		<div class="media">
			<div class="media-left">
				<a>
					<i class="media-icon fa-3x fa fa-truck"></i>
				</a>
			</div>
			<div class="media-body">
				<h3 class="media-heading text-orange"><strong>ผลิตและจัดส่งทันทีที่ลูกค้าสั่งซื้อ</strong></h3>
				<p>คุณไม่ต้องกังวลว่าการจัดส่งสินค้าของเราจะล่าช้า หรือ ไม่มีสินค้าจัดส่ง ทางเราจะผลิตสินค้าเพื่อจัดส่งโดยทันทีที่มีการสั่งซื้อ เพื่อให้เป็นไปตามข้อตกลงที่เราได้ให้ไว้ 
				<a href="{{ action('HelpController@getShipping') }}">ดูระยะเวลาผลิตและจัดส่งที่นี่</a>
				</p>
			</div>
		</div>
		<div class="media">
			<div class="media-left">
				<a>
					<i class="media-icon fa-3x fa fa-star-o"></i>
				</a>
			</div>
			<div class="media-body">
				<h3 class="media-heading text-orange"><strong>เลือกสินค้าที่คุณสนใจ มีลายใหม่ๆ ตลอด</strong></h3>
				<p>คุณไม่ต้องกังวลว่าสินค้าจะซ้ำซาก จำเจ ไม่ทันสมัย เพราะครีเอเตอร์จากทั่วประเทศ จะออกแบบสินค้าใหม่ๆ ออกมาตลอด รับประกันความสดใหม่ ไม่เหมือนใคร</p>
			</div>
		</div>
		<div class="media">
			<div class="media-left">
				<a>
					<i class="media-icon fa-3x fa fa-clock-o"></i>
				</a>
			</div>
			<div class="media-body">
				<h3 class="media-heading text-orange"><strong>จดจำ Affiliate ID ไว้ภายใน 24 ชั่วโมง</strong></h3>
				<p>ไม่ต้องกังวลเมื่อลูกค้าออกจากเว็บไซต์ เพราะหากลูกค้ากลับเข้ามาซื้อภายใน 24 ชั่วโมง คุณก็ยังได้รับส่วนแบ่ง</p>
			</div>
		</div>
	</div>
	<!--
	<table class="table-associate-content">
		<tr>
			<td>
				<a>
					<i class="media-icon fa-3x fa fa-pie-chart"></i>
				</a>
			</td>
			<td>
				<h3 class="text-orange media-heading"><strong>ส่วนแบ่งเริ่มต้นที่ 20% จากราคาขาย </strong></h3>
				<p>ส่วนแบ่งของคุณคิดจากราคาสินค้าที่คุณได้ตั้งไว้ เช่น ตั้งไว้ 390 บาท ส่วนแบ่งของคุณ 20% คุณจะได้รับ 50.7 บาท ในสินค้าทุกๆ ชิ้นที่ขายได้</p>
			</td>
		</tr>
		<tr>
			<td>
				<a>
					<i class="media-icon fa-3x fa fa-btc"></i>
				</a>
			</td>
			<td>
				<h3 class="text-orange media-heading"><strong>ไม่หักค่าใช้จ่าย</strong></h3>
				<p>คุณจะได้รับส่วนแบ่ง 10% เต็มจำนวนจากราคาขาย ไม่มีการหักต้นทุนสินค้า หรือค่าใช้จ่ายใดๆ ทั้งสิ้น</p>
			</td>
		</tr>
		<tr>
			<td>
				<a>
					<i class="media-icon fa-3x fa fa-truck"></i>
				</a>
			</td>
			<td>
				<h3 class="media-heading text-orange"><strong>ผลิตและจัดส่งทันทีที่ลูกค้าสั่งซื้อ</strong></h3>
				<p>คุณไม่ต้องกังวลว่าการจัดส่งสินค้าของเราจะล่าช้า หรือ ไม่มีสินค้าจัดส่ง ทางเราจะผลิตสินค้าเพื่อจัดส่งโดยทันทีที่มีการสั่งซื้อ เพื่อให้เป็นไปตามข้อตกลงที่เราได้ให้ไว้</p>
			</td>
		</tr>
		<tr>
			<td>
				<a>
					<i class="media-icon fa-3x fa fa-star-o"></i>
				</a>
			</td>
			<td>
				<h3 class="media-heading text-orange"><strong>เลือกสินค้าที่คุณสนใจ มีลายใหม่ๆ ตลอด</strong></h3>
				<p>คุณไม่ต้องกังวลว่าสินค้าจะซ้ำซาก จำเจ ไม่ทันสมัย เพราะครีเอเตอร์จากทั่วประเทศ จะออกแบบสินค้าใหม่ๆ ออกมาตลอด รับประกันความสดใหม่ ไม่เหมือนใคร</p>
			</td>
		</tr>
		<tr>
			<td>
				<a>
					<i class="media-icon fa-3x fa fa-clock-o"></i>
				</a>
			</td>
			<td>
				<h3 class="media-heading text-orange"><strong>จดจำ Affiliate ID ไว้ภายใน 24 ชั่วโมง</strong></h3>
				<p>ไม่ต้องกังวลเมื่อลูกค้าออกจากเว็บไซต์ เพราะหากลูกค้ากลับเข้ามาซื้อภายใน 24 ชั่วโมง คุณก็ยังได้รับส่วนแบ่ง</p>
			</td>
		</tr>
		
	</table>
	-->
</section>
@stop