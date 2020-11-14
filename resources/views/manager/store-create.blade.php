@extends('manager.layouts.master')
@section('css')
<style>
	.wrapper{
		text-align: center;
	}
	.wrapper img{
		width: 30%;
	}
	.form-group{
		margin-top: 50px;
	}
	#form-group-btn{
		margin-top: 50px;
	}
</style>
@stop
@section('script')
<script>
	$(document).ready(function() {
		
	});
</script>
@stop
@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="wrapper">
			<img src="{{ asset('images/newshop.png') }}">
			<form action="" class="form-horizontal">
				<div class="form-group">
					<label for="store-name" class="col-sm-3 control-label">ชื่อสโตร์</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="store-name" placeholder="ชื่อสโตร์">
					</div>
				</div>
				<div id="#form-group-btn" class="form-group">
					<div class="col-sm-4 col-sm-offset-4">
						<a class="btn btn-half btn-default">
							ยกเลิก
						</a>
						<a class="btn btn-half btn-primary" href="{{ url('store-update') }}">
							สร้าง
						</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@stop