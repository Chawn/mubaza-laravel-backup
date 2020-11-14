@extends('backend.layouts.master')
<link rel="stylesheet" href="{{ asset('css/crm.css') }}">
@section('script')

@section('content')
<div class="row">
	<div class="col-md-3 col-sm-3 col-xs-12 pull-right">
		
	</div>
	<div class="col-md-9 col-sm-9 col-xs-12">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title">การแบ่งประเภทลูกค้า</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<div class="col-md-3">
					<div class="info-box">
					<span class="info-box-icon bg-gray"></span>
						<div class="info-box-content">
							<span class="info-box-text">ลูกค้าใหม่</span>
							<span class="info-box-number">90<small>%</small></span>
						</div><!-- /.info-box-content -->
					</div>
				</div>
			</div>
		</div>
		<div class="content-left">			
			@for($i=0;$i<10;$i++)
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="box box-widget widget-user-2">
					<div class="widget-user-header bg-yellow">
						<div class="widget-user-image">
							<img class="img-circle" src="{{ asset('images/ex_01.png') }}" alt="User Avatar">
						</div>
						<h3 class="widget-user-username">เอ้ เพลิน เพลิน</h3>
						<h5 class="widget-user-desc">CEO Cyberia Shop</h5>
						<h5 class="widget-user-desc">ลูกค้าร้านค้า</h5>
					</div>
					<div class="box-footer no-padding">
						<ul class="nav nav-stacked">
							<li>
								<div class="box-body">
									<label>ที่อยู่&nbsp;:&nbsp;</label>231/136 ซอย 5 ถนนอุดรดุษฎี ตำบลหมากแข้ง อำเภอเมือง จังหวัดอุดรธานี 41000
								</div>								
							</li>
							<li>
								<div class="box-body">
									<label>เบอร์โทร&nbsp;:&nbsp;</label>
									{{ config('profile.phone-primary') }} <br> 
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			@endfor
		</div>
	</div>	
</div>
@stop