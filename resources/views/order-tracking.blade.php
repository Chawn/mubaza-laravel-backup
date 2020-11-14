@extends('layouts.full_width')

@section('script')
<script>
	$(document).ready(function() {
		var deviceHeight = $(window).height();
		$('.main').css({
			'min-height' : deviceHeight-52-84 +'px'
		})
	});
</script>
@stop
@section('css')
<link rel="stylesheet" href="{{ asset('css/order-tracking.css') }}">
<style>

</style>
@stop
@section('content')
<div class="col-md-12 text-center">
	<h1>ติดตามสถานะการสั่งซื้อ</h1>
	<form class="form-horizontal">
		<div class="form-group">
			<label for="order-id" class="control-label col-sm-3">ค้นหา</label>
			<div class="col-sm-6">
				<div class="input-group">
					<input id="order-id" type="text" class="form-control input-lg" placeholder="ใส่ Order-ID ที่นี่">
					<span class="input-group-btn">
						<button id="search-order" class="btn btn-lg btn-primary" type="button"><i class="fa fa-search"></i></button>
					</span>
				</div><!-- /input-group -->

			</div>
		</div>
	</form>
</div>
<div class="order-detail">
	<div class="col-md-7">
		<div class="panel well">
			<div class="panel-heading">
				<h3 class="title">Order&nbsp;ID&nbsp;:&nbsp;000111 <span class="pull-right">10/10/2558</span></h3>
			</div>
			<div class="panel-body">
				<div class="order-step">
					<div class="step step1 pass text-center">
						<p>ยืนยันการสั่งซื้อ</p>
						<div class="circle">
							<i class="fa fa-2x fa-money"></i>
						</div>
					</div>
					<div class="step step1 pass"></div>
					<div class="step step2 text-center">
						<p>กำลังดำเนินการ</p>
						<div class="circle">
							<i class="fa fa-2x fa-archive"></i>
						</div>
					</div>
					<div class="step step2"></div>
					<div class="step text-center">
						<p>จัดส่งแล้ว</p>
						<div class="circle">
							<i class="fa fa-2x fa-truck flip-horizontal"></i>
						</div>
					</div>
				</div>
				<table width="100%" class="table table-bordered">
					<thead>
						<tr>
							<th width="20%">
								วันที่
							</th>
							<th>
								รายละเอียด
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								12/12/24
							</td>
							<td>
								ยืนยันการชำระเงินแล้ว
							</td>
						</tr>
						<tr>
							<td>
								13/12/24
							</td>
							<td>
								เริ่มดำเนินการผลิต
							</td>
						</tr>
						<tr>
							<td>
								13/12/24
							</td>
							<td>
								ผลิตเสร็จแล้ว รอดำเนินการจัดส่ง
							</td>
						</tr>
					</tbody>
				</table>
			</div>			
		</div>		
	</div>
	<div class="col-md-5">
		<div class="panel well">
			<div class="panel-heading">
				<h3 class="title">Order Detail</h3>
			</div>
			<div class="panel-body ">
				@for ($i=0;$i<3;$i++)
				<div class="media">
					<div class="media-left">
						<a href="#">
							<img class="media-object" src="{{ asset('images/mockup/sports-grey.png') }}">
						</a>
					</div>
					<div class="media-body">
						<h4 class="media-heading">Mewwwot ปั่นน้ำใจ</h4>
						<p>เสื้อยืด คอกลม มาตรฐาน สีกรมท่า ไซต์ M</p>
					</div>
					<div class="media-right">
						1213฿
					</div>
				</div>
				@endfor
			</div>
			<div class="panel-footer">
				<h3 class="total">Total&nbsp;:&nbsp;<span>1212</span></h3>
			</div>
		</div>
	</div>
	
</div>
	
@stop