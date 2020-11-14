@extends('layouts.user_full_width')
@section('css')
<style>
#user-campaign-box {
	margin: 50px 0 0px 0;
	height: 150px;
}
.box-campaign {
	border: 1px solid #ddd;
	text-align: center;
	vertical-align: middle;
	border-radius: 8px;
}
.box-titile {
	margin: 10px 0 0 0;
	
}
.box-price {
	font-size: 38px;
	padding: 8px 0 ;
	letter-spacing: 2px;
}
#total-profit-fixbottom {
	display: none;
}
#nav-time-mobile {
	display: none;
}
@media (max-width: 480px){
	#user-header #about #u-favorite{
		display: none;
	}
	.box-title{
		font-size: 12px;
	}
	.box-price{
		font-size: 18px;
	}
	#dropdown-time {
		display: none;
	}
	#total-profit-fixbottom {
		display: block;
		padding: 5px 10px;
		color: #fff;
		background: #173964;
	}
	#user-campaign-box {
		margin: 5px 0 0 0;
	}
	.box-campaign{
		border-radius: 0px;
	}
	#nav-time-mobile {
		display: block;
	}
	.pagination{
		margin:5px 0;
	}
	.table-gray {
		font-size: 12px;
	}
	
}

</style>
@stop
@section('script')
<script>
	jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
	
</script>
@stop
@section('content')
<div id="user-campaign">
	{{-- @if(count($campaigns) > 0) --}}
	<div class="row ">
		<div class="col-sm-12">
			<div class="box-blank">
				<div class="box-header ">
					<div class="form-inline">
						<div class="row">
							<div class="col-sm-6 col-xs-6">
								<div class="dataTables_length" id="example1_length">
									<label>Show 
										<select name="example1_length" aria-controls="example1" class="form-control input-sm">
											<option value="10">10</option>
											<option value="25">25</option>
											<option value="50">50</option>
											<option value="100">100</option>
										</select> entries
									</label>
								</div>
							</div>
							<div class="col-sm-6 col-xs-6">
								<div id="example1_filter" class="dataTables_filter">
									<div class="pull-right">
										<label>
											<form action="">
												ค้นหา: 
												<input type="text" class="form-control" name="q" placeholder="">
											</form>
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="box-body box-product">
					<div class="row">
						@foreach($campaigns as $campaign)
							<div class="col-md-3 col-sm-3 col-xs-6 col-mobile">
								<div class="product-box">
									<a href="{{ action('CampaignController@showCampaign', $campaign->url) }}">
										<div class="product-img">
											<img src="{{ action('CampaignController@getFile', [$campaign->id, $campaign->frontCover()]) }}">
										</div>
									</a>
									<div class="product-detail">
										<div class="product-name ">
											{{ $campaign->title }}
										</div>
										<div class="product-description ">
											<span class="price">
												฿{{ $campaign->primaryPrice() }}
											</span>
											<span class="wish pull-right">
												@if(\Auth::user()->check())
													<a class="btn-wish {{ \Auth::user()->user()->isAddedToWishList($campaign->id) ? 'wished': '' }}"
													   data-campaign-id="{{ $campaign->id }}"
													   data-user-id="{{ \Auth::user()->user()->id }}">
														&nbsp;<i class="fa  {{ \Auth::user()->user()->isAddedToWishList($campaign->id) ? 'fa-heart': 'fa-heart-o' }} "></i>&nbsp;
													</a>
												@else
													<a class="btn-wish-unlogin" data-toggle="modal" href="#modal-login">
														&nbsp;<i class="fa fa-heart-o"></i>&nbsp;
													</a>
												@endif
											</span>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
       </div>
	</div>
	{{-- @else 
		<div class="alert text-center" role="alert">ยังไม่มีแคมเปญในขณะนี้</div>
	@endif
	--}}
</div>
@stop