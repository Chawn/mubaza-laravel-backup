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
				<img class="media-object" src="{{asset('images/user-ban_red.png')}}" alt="user-ban" >
			</div>
			<div class="media-body text-center">
				<h2>ขออภัย บัญชีของคุณถูกระงับ</h2>
				<p>บัญชีของคุณถูกระงับ กรุณาติดต่อผู้ดูแลระบบ</p>
			</div>
		</div>
	</div>
</div>
@stop