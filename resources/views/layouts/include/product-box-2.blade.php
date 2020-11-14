
	<div class="product-img">
		<a href="{{ action('CampaignController@showCampaign', $campaign->url) }}{{ \Request::has('affid') ? '?affid=' . $affiliate->id : '' }}">
			<img class="lazy"  src="{{asset('images/t-holder.png')}}"
				data-original="{{ action('CampaignController@getFile', [$campaign->id, $campaign->frontCover('image_front_medium')]) }}">
		</a>
	</div>