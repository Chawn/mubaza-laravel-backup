@extends('layouts.index_full_width')
@section('meta')
	<meta name="Description" content="GG7 เว็บไซต์จำหน่ายเสื้อยืดคุณภาพสูง เกรดพรีเมี่ยม SuperSoft Micro Brush t-shirt เสื้อยืดราคาถูกกว่า">
	<meta name="Keywords" content="เสื้อยืด, แฟชั่น, เสื้อยืดผู้ชาย, เสื้อยืดผู้หญิง, เสื้อยืดราคาถูก, เสื้อยืดคุณภาพสูง, เสื้อยืด ​3D">
@stop
@section('css')
	<link rel="stylesheet" href="{{asset('css/landing.css')}}">
	<link rel="stylesheet" href="{{asset('css/flipclock.css')}}">
	<style>
	body{
		background: #000;
		background-position: top center;
		background-size: 100%;
		font-family: 'ThaiSansNeue-Regular';
	}
	#main-nav-wrapper{
		display: none;
	}
	#footer-main{
		display: none;
	}
	.main{
		color:#22313f;
		background: #000;
	}
	#section-slide{
		display: none;
	}
	#timer{
		display: inline-block;
		margin-bottom: auto;
		width: auto;
		margin-top: 30px;
	}
	.btn.btn-white.border{
	    display: block;
	    width: 30%;
	    margin: auto;
	    margin-top: 35px;
	    font-size: 20px;
	}
	.flip-clock-divider .flip-clock-label{
		color: #fff;
	}
	@media(max-width: 767px){
		.btn.btn-white.border{
			width: 100%;
		}
		#timer{
			display: none;
		}
	}
</style>
@stop
@section('script')
<script src="{{asset('js/jquery.countdownTimer.min.js')}}"></script>
<script src="{{asset('js/flipclock.js')}}"></script>
<script>
	$(document).ready(function() {
		$('#countdown').countdowntimer({
			dateAndTime : "2016/01/05 00:00:00",

		});

		var currentDate = new Date();

		var futureDate  = new Date(2016,0,5);

		var diff = futureDate.getTime() / 1000 - currentDate.getTime() / 1000;

		clock = $('#timer').FlipClock(diff, {
			clockFace: 'DailyCounter',
			countdown: true
		});


	});
</script>
@stop
@section('content')
<section id="landing">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="jumbotron text-center">
					<img id="GG7-logo" src="{{asset('images/gg-seven-logo.png')}}" alt="GG7">
					<h1>เตรียมพบกับเรา เร็ว ๆ นี้</h1>
					<div id="timer"></div>
					<div id="countdown"></div>
					<a href="{{ action('AssociateController@getIndex') }}" class="btn btn-white border">สมัครเป็นครีเอเตอร์</a>
					<a href="{{ url('/') }}?show=index" class="btn btn-white border">
						เข้าสู่หน้าหลัก
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
<!--
<section id="section-cover">
	<div class="container">
		<div class="row">
			<div id="cover-coming">
				<div class="col-md-6">
					<div class="cover-img">
						<div class="img">
							
						</div>
						
					</div>
				</div>
				<div class="col-md-6">
					<div id="cover-text">
						<div class="box text-center">
							<h1 class="title">
								เตรียมพบกับ GG7 เร็วๆนี้
							</h1>
							<p>
								เตรียมพบกับเว็บไซต์เสื้อยืด สดใหม่ เหมาะกับไลฟสไตน์คนยุคดิจิตอล 
							</p>
						</div>
						<div id="countdown" class="well">
							<h1 class="title">
								<span>30</span>&nbsp;:&nbsp;<span>23</span>&nbsp;:&nbsp;<span>30</span>&nbsp;:&nbsp;<span>59</span>
							</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section id="section-even">
	<div class="container">
		<div class="row">
			<div id="even-detail">
				<div class="col-md-12">
					<div class="box">
						<h1 class="title">ขอเชิญครีเอเตอร์เข้าร่วมกิจกรรมออกแบบลายเสื้อสุดชิค</h1>
						<div class="sub-detail">
							<p>
								กิจกรรมประกวดออกแบบลายเสื้อยืด เพื่อสร้างเป็นสินค้าสำหรับเว็บของเรา โดยจะคัดเลือก 50 ลาย มาผลิตเป็นเสื้อยืดจริง รับเงินรางวัล รางวัลละ 200 บาท 
								กิจกรรม เริ่มวันที่ 1 ธันวาคม 2558 - 31 ธันวาคม 2558 และประกาศผล วันที่ 5 มกราคม 2559
							</p>
						</div>
					</div>
					<a id="btn-join" href="#" class="btn title">สมัครเข้าร่วมกับเรา</a>
				</div>
			</div>
		</div>	
	</div>
</section>
-->
@stop