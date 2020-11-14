@extends('backend.layouts.master')
<link rel="stylesheet" href="{{ asset('css/coupon.css') }}">
@section('css')
<style>
	.form-horizontal p {
		padding-top: 7px;
    	margin-bottom: 0;
	}
	#table-coupon tbody tr td:first-child{
		width: 20%;
		font-weight: bold;
	}
	.case{
		margin-bottom: 25px;
		border-bottom: 1px solid #ddd;
	}
</style>
@stop
@section('content')
<!-- ### สถิติ ทำเผื่อไว้เฉยๆนะพี่ เผื่อมีคนอยากดู ช่องมันว่าง ### -->
{{-- 
<div class="col-md-4 col-sm-4 col-xs-12 pull-right">
	<div class="box box-solid">
		<div class="box-header with-border">
			<h4 class="box-title">สถิติ</h4>
			<p class="box-title pull-right">ประจำเดือนธันวาคม</p>
		</div>
		<div class="box-body">
			<div class="case">
				<p><b>วันที่ที่มีการใช้มากสุด</b></p>
				<div class="progress">
	                <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
	                  60%
	                </div>
	                <div class="progress-bar progress-bar-blue" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
	                  30%
	                </div>
	                <div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
	                   10%
	                </div>
              	</div>
              	<ol>
              		<li class="text-green">
              			<p>วันอาทิตย์ 60%</p>
              		</li>
              		<li class="text-blue">
              			<p>วันจันทร์ 30%</p>
              		</li>
              		<li class="text-yellow">
              			<p>วันพุธ 10%</p>
              		</li>
              	</ol>
			</div>
			<div class="case">
				<p><b>ช่วงวันที่ที่มีการใช้มากสุด</b></p>
				<div class="progress">
	                <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 48%">
	                  48%
	                </div>
	                <div class="progress-bar progress-bar-blue" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
	                  30%
	                </div>
	                <div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 22%">
	                   22%
	                </div>
              	</div>
              	<ol>
              		<li class="text-green">
              			<p>วันอาทิตย์ 60%</p>
              		</li>
              		<li class="text-blue">
              			<p>วันจันทร์ 30%</p>
              		</li>
              		<li class="text-yellow">
              			<p>วันพุธ 10%</p>
              		</li>
              	</ol>
			</div>
			<div class="case">
				<p><b>เพศ</b></p>
				<div class="progress">
	                <div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 52%">
	                  52%
	                </div>
	                <div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 48%">
	                  48%
	                </div>
              	</div>
              	<ol>
              		<li class="text-red">
              			<p>ชาย 52%</p>
              		</li>
              		<li class="text-yellow">
              			<p>หญิง 48%</p>
              		</li>
              	</ol>
			</div>
		</div>
	</div>
</div>
--}}
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="box box-solid">
		<div class="box-header with-border">
			<h4 class="box-title">{{ $coupon->coupon_name }}</h4>
			<h4 class="box-title pull-right">#{{ str_pad($coupon->id, 6, 0, STR_PAD_LEFT) }} &nbsp;<span class="label label-success">{{ $coupon->getStatusName() }}</span></h4>
		</div>
		<div class="box-body">
			<table id="table-coupon" class="table table-bordered">
				<tbody>
					<tr>
						<td>รหัสคูปอง</td>
						<td>{{ $coupon->coupon_code }}</td>
					</tr>
					<tr>
						<td>รายละเอียด</td>
						<td>{{ $coupon->coupon_detail }}</td>
					</tr>
					<tr>
						<td>ส่วนลด</td>
						<td>{{ $coupon->coupon_discount_number }}&nbsp;{{ $coupon->coupon_discount_type == 'price' ? 'บาท' : '%' }}</td>
					</tr>
					<tr>
						<td>
							วันที่สร้าง
						</td>
						<td>
							{{ $coupon->created_at->format('d/m/Y H:i') }}
						</td>
					</tr>
					<tr>
						<td>
							วันหมดอายุ
						</td>
						<td>
							<span class="text-red">{{ $coupon->coupon_condition_end_date->format('d/m/Y H:i') }}</span>
						</td>
					</tr>
						<td>
							เงื่อนไข
						</td>
						<td>
							<ul>
								<li>
									ราคารวมขั้นต่ำ {{ $coupon->coupon_condition_at_least_price }} บาท
								</li>
								<li>
									จำนวนการใช้งานสูงสุด (Order) {{ $coupon->coupon_condition_max_use_per_user }}
								</li>
								<li>
									จำนวน User สูงสุด {{ $coupon->coupon_condition_max_user }}
								</li>
							</ul>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="box box-solid">
		<div class="box-header with-border">
			<h4 class="box-title">การใช้</h4>
			<h4 class="box-title pull-right">จำนวนผู้ใช้งานทั้งหมด&nbsp;:&nbsp;<span class="text-blue">{{ $coupon->redeemed->count() }}&nbsp;คน</span></h4>
		</div>
		<div class="box-body">
			<table class="table table-bordered">
				<thead>
				<tr><th>ID</th><th>วันที่</th><th>ชื่อผู้ใช้</th><th>เลขที่สั่งซื้อ</th><th>ส่วนลด</th><th>ยอดสุทธิ</th><th>สถานะ</th></tr>
				</thead>
				<tbody>
				@foreach($redeemCoupons as $redeemCoupon)
					<tr>
						<td>
							{{ $redeemCoupon->id }}
						</td>
						<td>
							{{ $redeemCoupon->created_at->format('d/m/Y H:i') }}
						</td>
						<td>
							{{ $redeemCoupon->user->full_name }}
						</td>
						<td>
							<a href="{{action('BackendController@getOrderDetail', $redeemCoupon->order_id)}}">
								{{ $redeemCoupon->order_id }}
							</a>
						</td>
						<td>
							{{ $redeemCoupon->order->coupon_discount_total }}
						</td>
						<td>{{ $redeemCoupon->order->net_price_total }}</td>
						<td>{{ $redeemCoupon->redeem_status }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="box-footer clearfix">
			{!! str_replace('/?', '?', $redeemCoupons->render()) !!}
		</div>
	</div>
</div>
@stop