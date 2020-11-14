@extends('layouts.error')
@section('css')
<style>
	body{
		background: #f5f5f5;
	}
	#page-404{
		padding-top: 60px;
	}
	.media-left{
		width: 35%;
	}
	.media-object{
		width: 100%;
	}
	.media-body{
		padding:30px;
	}
</style>
@stop
@section('content')
<div class="row">
	<div class="col-md-12">
		<div id="page-404" class="media">
			<div class="media-left">
				<img class="media-object" src="{{asset('images/tshirt404.png')}}" alt="404" >
			</div>
			<div class="media-body text-center">
				<h1>ขออภัย ไม่พบหน้าที่คุณต้องการ</h1>
				<p>หน้าเว็บที่คุณต้องการจะเข้าถึงอาจเสียหาย, ถูกลบไปหรือย้ายไปยังหน้าอื่น</p>
				<p class="text-center">
					<a href="{{ url('/') }}" class="btn btn-primary">	
						<i class="fa fa-home"></i> หน้าแรก
					</a>
					<a href="{{ url('search') }}" class="btn btn-primary">	
						<i class="fa fa-shopping-cart"></i> ช้อป
					</a>
				</p>
			</div>
		</div>
	</div>
</div>
@stop