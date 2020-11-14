@extends('backend.layouts.master')
<link rel="stylesheet" href="{{ asset('datetimepicker-master/jquery.datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/coupon.css') }}">
@section('script')
	<script src="{{ asset('datetimepicker-master/jquery.datetimepicker.js') }}"></script>
	<script>
		$(document).ready(function() {
//		$(".date-picker").datepicker();
			jQuery('.date-picker').datetimepicker({
				format: "d/m/Y H:i"
			});

			$("#btn-add").click(function() {
				$("#coupon-form").submit();
			});
		});
	</script>
@stop
@section('css')
<style>
	.form-horizontal .form-group{
		margin-left: 0px !important;
	}
</style>
@stop
@section('content')
	<div class="col-md-3 col-sm-3 col-xs-12 pull-right">
		<div class="box">
			<div class="box-header with-border">
				<h4 class="box-title">เครื่องมือ</h4>
			</div>
			<div class="box-body">
				<div id="btn-tools-group" class="btn-tools-group collapse in">
					<a id="btn-add" href="javascript:void(0)" class="btn btn-block btn-success">บันทึก</a>
					<a id="btn-delete" href="{{ action('BackendController@getCoupon') }}" class="btn btn-block btn-default">ยกเลิก</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-9 col-sm-9 col-xs-12">
		<div class="box">
			<div class="box-header with-border">
				<h4 class="box-title">สร้างคูปอง</h4>
			</div>
			<div class="box-body">
				<form action="{{ url('backend/coupon/store') }}" method="post" id="coupon-form" class="form-horizontal">
					@foreach ($errors->all() as $error)
						<p class="alert alert-warning">{{ $error }}</p>
					@endforeach
					{!! csrf_field() !!}
					<input type="hidden" name="id" value="{{ $coupon->id }}">
					<div class="form-group">
						<label for="coupon-name" class="col-sm-3 control-label">ชื่อคูปอง</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="coupon-name" name="coupon_name" value="{{ $coupon->coupon_name }}">
						</div>
					</div>
					<div class="form-group">
						<label for="coupon-detail" class="col-sm-3 control-label">รายละเอียด</label>
						<div class="col-sm-6">
							<textarea name="coupon_detail" id="coupon-detail" cols="30" rows="10" class="form-control">{{ $coupon->coupon_detail }}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="coupon-code" class="col-sm-3 control-label">รหัสคูปอง</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="coupon_code" id="coupon-code" value="{{ $coupon->coupon_code }}">
						</div>
					</div>
					<div class="form-group">
						<label for="input-discount" class="col-sm-3 control-label">ส่วนลด</label>
						<div class="col-sm-9">
							<div class="form-inline">
								<div class="form-group spinner-none">
									<input id="input-discount" name="coupon_discount_number" type="number" class="form-control" value="{{ $coupon->coupon_discount_number }}">
								</div>
								<select name="coupon_discount_type" id="select-discount" class="form-control">
									<option value="price" {{ $coupon->coupon_discount_type == 'price' ? 'selected' : '' }}>บาท</option>
									<option value="percent" {{ $coupon->coupon_discount_type == 'percent' ? 'selected' : '' }}>%</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="discount" class="col-sm-3 control-label">เงื่อนไข</label>
						<div class="col-sm-9">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="coupon_condition_at_least_price_flag" {{ $coupon->coupon_condition_at_least_price_flag == 'yes' ? 'checked' : '' }} >
									ราคารวมขั้นต่ำ
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="coupon_condition_end_date_flag" {{ $coupon->coupon_condition_end_date_flag == 'yes' ? 'checked' : '' }} >
									วันสิ้นสุด
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="coupon_condition_max_use_per_user_flag" {{$coupon->coupon_condition_max_use_per_user_flag == 'yes' ? 'checked' : ''}} >
									จำนวนการใช้งานสูงสุด (Order)
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="coupon_condition_max_user_flag" {{ $coupon->coupon_condition_max_user_flag == 'yes' ? 'checked' : '' }}>
									จำนวน User สูงสุด
								</label>
							</div>
						</div>
					</div>
					<div id="form-minimum" class="form-group">
						<label for="input-minimum" class="col-sm-3 control-label">ราคารวมขั้นต่ำ</label>
						<div class="col-sm-6">
							<div class=" spinner-none">
								<input id="input-minimum" type="number" class="form-control" name="coupon_condition_at_least_price"
									   value="{{ $coupon->coupon_condition_at_least_price }}">
							</div>
						</div>
						<div class="col-sm-3">
							<p class="back-label">บาท</p>
						</div>
					</div>
					<div id="form-exp" class="form-group">
						<label for="input-exp" class="col-sm-3 control-label">วันสิ้นสุด</label>
						<div class="col-sm-6">
							<div class="input-group">
								<input id="input-exp" type="text" class="date-picker form-control" name="coupon_condition_end_date"
									   value="{{ $coupon->coupon_condition_end_date ? $coupon->coupon_condition_end_date->format('d/m/Y H:i') : ''}}" />
								<label for="input-exp" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>
								</label>
							</div>
						</div>
					</div>
					<div id="form-times" class="form-group">
						<label for="input-times" class="col-sm-3 control-label">จำนวนการใช้งาน</label>
						<div class="col-sm-6">
							<div class="spinner-none">
								<input id="input-times" type="number" class="form-control" name="coupon_condition_max_use_per_user"
									   value="{{ $coupon->coupon_condition_max_use_per_user ? $coupon->coupon_condition_max_use_per_user : 1}}">
							</div>
						</div>
						<div class="col-sm-3">
							<p class="back-label">ครั้ง/ผู้ใช้</p>
						</div>
					</div>
					<div id="form-user" class="form-group">
						<label for="input-user" class="col-sm-3 control-label">จำนวนผู้ใช้</label>
						<div class="col-sm-6">
							<div class="spinner-none">
								<input id="input-user" type="number" class="form-control" name="coupon_condition_max_user" value="{{ $coupon->coupon_condition_max_user }}">
							</div>
						</div>
						<div class="col-sm-3">
							<p class="back-label">ผู้ใช้</p>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label">สถานะ</label>
						<div class="col-sm-6">
							<div class="radio">
								<label>
									<input type="radio" name="status" value="enable" {{ $coupon->status == 'enable' ? 'checked' : '' }}/>ใช้งาน
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="status"
										   value="draft" {{ $coupon->status == 'draft' ? 'checked' : '' }}/>ฉบับร่าง
								</label>
							</div>
							<div class="radio"><label><input type="radio" name="status" value="disable" {{ $coupon->status == 'disable' ? 'checked' : '' }} /> ปิดการใช้งาน</label></div>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop