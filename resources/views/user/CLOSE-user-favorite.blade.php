@extends('user.layouts.master')
@section('css')
<style>
.media{
	border: 1px solid transparent;
	padding: 10px;
}
.media:hover {
	border: 1px solid #ddd;
	box-shadow: 2px 2px 5px #ddd;
}
.media-left {
	width: 120px;
}
.media-left img {
	max-width: 115px;
}
@media(max-width: 480px){
    #user-header #about #u-favorite{
        display: none;
    }
}

</style>
@stop
@section('content')
<div class="row-fluid">
    @forelse($favorites as $favorite)
    <div class="col-md-4 col-sm-4 col-xs-12">
        
        <a class="product-box" href="{{ action('SellController@showCampaign', $favorite->campaign->url) }}">
            <div class="product-img">
                <img src="{{ $favorite->campaign->back_cover ? $favorite->campaign->design->image_back_preview : $favorite->campaign->design->image_front_preview }}"
                onmouseover="this.src='{{$favorite->campaign->back_cover ? $favorite->campaign->design->image_front_preview : $favorite->campaign->design->image_back_preview}}';"
                onmouseout="this.src='{{$favorite->campaign->back_cover ? $favorite->campaign->design->image_back_preview : $favorite->campaign->design->image_front_preview}}';">
            </div>
            <div class="product-detail">
                <div class="product-name text-left">
                    {{ $favorite->campaign->title }}
                </div>
                <div class="product-description">
                    <div class="price text-left">
                        <span class="time">{{ $favorite->campaign->getRemainTime() }}</span>
                    </div>
                    <div class="sold text-right">
                        {{ $favorite->campaign->getSold() }}
                    </div>
                </div>
            </div>
        </a>
    </div>
    @empty
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="alert text-center" role="alert">ยังไม่มีแคมเปญที่ชื่นชอบ</div>
    </div>
    @endforelse
</div>
<div class="row-fluid">
    <div class="col-md-12">
        <nav class="pull-right">
            {!! str_replace('/?', '?', $favorites->render()) !!}
        </nav>
    </div>
</div>
@stop