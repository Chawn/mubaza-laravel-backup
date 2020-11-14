@extends('backend.layouts.master')
<link rel="stylesheet" href="{{ asset('css/new-backend.css') }}">
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-body">
				<div class="col-md-9">
					<div class="box-header">
						<h3 class="box-title"><label>รหัสสั่งซื้อ&nbsp;:&nbsp;</label>123123</h3>
					</div>
					<div class="box-body">
						<p><label>วันที่จ่ายเงิน&nbsp;:&nbsp;</label>12-12-24</p>
						<p><label>เหลือเวลาดำเนินการ&nbsp;:&nbsp;</label>5 วัน</p>
					</div>
				</div>
				<div class="col-md-3">
					<p>
						<button class="btn btn-lg btn-success text-center">
							<i class="fa fa-check"></i> 
			                ผลิตเสร็จแล้ว
			            </button>
					</p>
					<p>
						<button class="btn btn-lg btn-default text-center">
							<i class="fa fa-print"></i> 
			                พิมพ์ใบปะหน้า
			            </button>
					</p>
				</div>
			</div>		
		</div>
	</div>
		
</div>
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-body">
				@for($i=1;$i<=6;$i++)
				<div class="col-md-6">
					<div class="box-product-detail">
						<div class="product-img">
							<img src="{{ asset('images/mockup/img'.$i.'.jpg') }}">
						</div>
						<div class="product-detail">
							<a href="#">
								<h3>เสื้อยืดศักรินทร์</h3>
							</a>
							<p>
								เสื้อยืดมาตรฐาน คอกลม สีแดง
							</p>
							<p>
								<label>
									ขนาด&nbsp;:&nbsp;M
								</label>
							</p>
							<p>
								<label>
									จำนวน&nbsp;:&nbsp;2 ตัว
								</label>								
							</p>
						</div>
					</div>
				</div>
				@endfor
			</div>
		</div>
	</div>	
</div>
@stop