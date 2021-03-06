<div class="product-box">
	<div class="product-img">
		<a href="{{ action('CampaignController@showCampaign', $campaign->url) }}{{ \Request::has('affid') ? '?affid=' . $affiliate->id : '' }}">
			<img class="lazy"  src="{{asset('images/t-holder.png')}}"
				data-original="{{ action('CampaignController@getFile', [$campaign->id, $campaign->frontCover('', 'image_front_medium')]) }}">
		</a>
	</div>

	<div class="product-detail">
		<div class="product-name text-center">
			<a href="{{ action('CampaignController@showCampaign', $campaign->url) }}{{ \Request::has('affid') ? '?affid=' . $affiliate->id : '' }}">
				{{ $campaign->title }}
			</a>
		</div>

		<div class="product-description ">
			<span class="price ">
				<span class="price-number">
				฿{{ $campaign->primaryPrice() }}
				</span>
				<!-- <span class="unit">/ตัว</span>-->
				<span class="wish pull-right">
					@if(\Auth::user()->check())
						<a
						   class="add-to-wish-list wish text-grey"
						   data-user-id="{{ \Auth::user()->user()->id }}"
						   data-campaign-id="{{ $campaign->id }}"
						   href="javascript:void(0)">
							<i class="fa  {{ \Auth::user()->user()->isAddedToWishList($campaign->id) ? 'fa-heart': 'fa-heart-o' }}"></i>
						</a>
					@else
						<a class="btn-wish-unlogin" data-toggle="modal" href="#modal-login">
							<i class="fa fa-heart-o"></i>&nbsp;
						</a>
					@endif
				</span>
				<!--
				<br>
				<small>Free Shipping</small>
				-->
			</span>

			{{-- <span class="wish pull-right">
				<a class="btn-wish-unlogin" data-toggle="modal" href="#modal-login">
					<i class="fa fa-heart-o"></i>&nbsp;
				</a>
			</span>		 --}}
		</div>
	</div>
</div>