@extends('layouts.help')
@section('css')
<style>
#check-order-detail {
	min-height: 250px;
}
#input-order-id {
	width: 350px;
	margin-left: 15px;
}
label {
	float: left;
	font-weight: normal;
}
#show-order-detail i {
	margin-right: 10px;
}
#show-order-detail {
	padding: 35px 0 0 15px;
}
</style>
@stop
@section('content')
<div id="check-order-detail">
	<div class="form-group">
		<label for="input-order-id" class="col-sm-12">กรุณาระบุหมายเลขการสั่งซื้อของคุณ</label>
		<input id="input-order-id" class="form-control" type="text" placeholder="ระบุหมายเลขการสั่งซื้อ">
	</div>
	<div id="show-order-detail">
		<p class="bold"><span>ผลการค้นหา หมายเลขการสั่งซื้อ</span>  123456789</p>
		<div class="alert alert-success" role="alert">
			<i class="fa fa-check"></i>
			สถานะการสั่งซื้อ ส่งแล้ว th12345678
			
		</div>
		<div class="alert alert-none" role="alert">
			สถานะการสั่งซื้อ กำลังผลิต
		</div>
	</div>
</div>
@stop