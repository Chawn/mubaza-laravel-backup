@extends('user.layouts.master')
@section('css')
	<style>
		#user-campaign-view {
			min-height: 450px;
			margin: 25px 0;
		}
		#user-campaign-view-img img {
			max-width: 100%;
		}
		#campaign-detail-header {
			min-height: 100px;
		}

		.campaign-detail-designer {
			font-size: 16px;
			color: #e67e22;
			display: block;
			margin: 5px 0 5px 0;
		}
		.campaign-detail-designer:hover {
			color: #e67e22;
		}
		.campaign-detail-designer:focus {
			color: #e67e22;
			text-decoration: none;
		}
		.select-status {
			width: 200px;
			height: 35px;
			border: 1px solid #ddd;
		}
		#save-campaign-status {
			margin:  0 0 0 15px;
		}
		.well {
			background: transparent;
			border-radius: 0px;
			margin: 5px 0 10px 0;
			min-width: 640px;
		}
		/**/
		.box-campaign {
			border: 1px solid #DDD;
			text-align: center;
			vertical-align: middle;
			border-radius: 8px;
		}
		.box-campaign h2 {
			text-align: center;
		}
		.box-campaign p {
			text-align: center;
		}
		#campign-detail-box {

		}
		#campaign-detail-sold {

		}
		#user-campaign-box{
			margin: 25px 0 ;
			min-height: 100px;

		}
		.campaign-detail-sold-box {
			min-height: 140px;
			margin-bottom: 10px;
			padding-top: 5px;
		}

		.campaign-detail-sold-icon {
			width: 120px;
			height: 120px;
			border-radius: 50%;
			background: #202020;
			text-align: center;
			float: left;
			margin-right: 30px;
		}
		.campaign-detail-sold-icon img {
			max-width: 80px;
			max-height: 80px;
			margin-top: 20px;
		}

		.campaign-detail-sold-right {
			min-height: 120px;
		}
		.product-type {
			font-size: 20px;
		}
		.product-price {
			font-size: 16px;
			margin:  10px 0 10px 0;
		}
		.product-sold {
			font-size: 16px;
		}

		#group-btn-flip {
			margin: 5px 0 ;
			text-align: center;
		}
		.btn-backend-flip-img {
			width: 40px;
			height: 40px;
			line-height: 40px;
			border-radius: 50%;
			background: #ddd;
			color: #202020;
			border: 1px solid transparent;
			text-align: center;
			vertical-align: middle;
			margin-right: 10px;
			padding: 0;
		}
		.btn-backend-flip-img:focus {
			border-radius: 50%;
		}
		.btn-backend-flip-img:active {
			border-radius: 50%;
			border: 1px solid transparent;
		}
		.flip-choose {
			background: #202020;
			color: #fff;
		}
		.flip-choose:hover {
			background: #202020;
			color: #fff;
		}
		.flip-choose:focus {
			background: #202020;
			color: #fff;
		}

		.box-title {
			margin: 10px 0 0 0;

		}
		.box-content {
			font-size: 26px;
			padding: 8px 0 ;
			letter-spacing: 2px;
		}
		#description img {
			max-width: 100% !important;
			height: auto !important;
		}
	</style>
@stop
@section('script')
	<script src="{{ asset('js/countdown/jquery.countdown.min.js') }}"></script>

	<script type="text/javascript">

		$(document).ready(function(){
			$('.time').countdown($('.time').attr('data-end-time')).on('update.countdown', function (event) {
				$(this).html(event.strftime(''
						+ '<h2>%-D:%H:%M:%S</h2>'
						+ '<p>วัน:ชม:นาที:วินาที</p>'
				));
			});
		});
	</script>
@stop
@section('content')
	<div class="row">
		<div class="col-md-12">
			@if($campaign->status->name == 'ban')
			<div class="alert alert-warning">แคมเปญนี้ถูกระงับเนื่องจากสาเหตุ : {{ $campaign->remark }}</div>
				@endif
			<div class="pull-right">
				@if($campaign->status->name == 'running' && $campaign->end > \Carbon::now())
					<a class="btn btn-default"
					   href="{{ action('UserController@getEditCampaign', [$user->getID(), $campaign->id]) }}"><i
								class="fa fa-pencil"></i>&nbsp;แก้ไข</a>
					@if($campaign->totalOrder() < 1)
					<a class="btn btn-warning" href="{{ action('CampaignController@getClose', $campaign->id) }}"><i
								class="fa fa-minus-circle"></i>&nbsp;ปิดการขาย</a>
						@endif
				@endif
					{{--@if($campaign->status->name != 'running' || $campaign->end < \Carbon::now())--}}
						{{-- <a class="btn btn-success" href="{{ action('CampaignController@getReopen', $campaign->id) }}"--}}
                           {{--aria-disabled="true"><i class="fa fa-retweet"></i>&nbsp;เปิดแคมเปญอีกครั้ง</a> --}}
						{{--<a href="{{ action('UserController@getDeleteCampaign', [$user->getID(), $campaign->id]) }}"--}}
						   {{--class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;ลบแคมเปญนี้</a>--}}
					{{--@endif--}}
				@if($campaign->status->name != 'ban')
						<a class="btn btn-default" href="{{ action('SellController@showCampaign', $campaign->url) }}">
					<span class="fa fa-eye"></span> ดูแคมเปญนี้
				</a>
					@endif
			</div>
	</div>
		</div>
	</div>
	<div id="user-campaign-box" class="row">
		<div class="col-md-4">
			<div class="box-campaign">
				<p class="box-title">ขายแล้ว</p>
				<p class="box-content">{{ $campaign->totalOrder() }} / {{ $campaign->goal }}</p>
			</div>
		</div>
		<div class="col-md-4">
			<div class="box-campaign time" data-end-time="{{ $campaign->status->name == 'running' ? $campaign->end : '' }}">
				<p class="box-title">เหลือเวลา</p>
				<p class="box-content">หมดเวลาแล้ว</p>
			</div>
		</div>
		<div class="col-md-4">
			<div class="box-campaign">
				<p class="box-title">รายได้</p>
				<p class="box-content">{{ $campaign->totalProfit() }}</p>
			</div>
		</div>
	</div>
	<div id="user-campaign-view" class="row">
		<div class="col-md-5">
			<div id="user-campaign-view-img">
				<img id="user-campaign-view-img-font" src="{{ $campaign->design->image_front_preview }}">
				<img id="user-campaign-view-img-back" src="{{ $campaign->design->image_back_preview }}">
			</div>
			<div id="group-btn-flip">
				<a id="flip-font" class="btn btn-backend-flip-img flip-choose" href="javascript:void(0)">หน้า</a>
				<a id="flip-back" class="btn btn-backend-flip-img " href="javascript:void(0)">หลัง</a>
			</div>
		</div>
		<div class="col-md-7">
			<div id="campaign-detail-header">

				<h1 >{{ $campaign->title }}</h1>

				<div id="description">

					{!! $campaign->description !!}
				</div>

			</div>
			<div id="campaign-detail-sold">
				<div class="campaign-detail-sold-box">
					<div class="campaign-detail-sold-right">
						<h3>สินค้าที่เปิดขาย</h3>
						<table class="table">
							<thead>
							<tr>
								<th>สินค้า</th>
								<th>ราคาขาย</th>
								<th>ขายแล้ว</th>
							</tr>
							</thead>
							<tbody>
							@forelse($campaign->products as $product)
								<tr>
									<td>{{ $product->product->name }}&nbsp;{{ $product->product_image->color_name }}</td>
									<td>{{ $product->sell_price }}&nbsp;บาท</td>
									<td>{{ $product->getOrderedItem() }}&nbsp;ตัว</td>
								</tr>
							@empty
								<tr>
									<td colspan="3">ไม่มีรายการสินค้า</td>
								</tr>
							@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
@stop