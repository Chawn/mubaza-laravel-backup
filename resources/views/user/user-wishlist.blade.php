@extends('user.layouts.full-width')
@section('script')
<script src="{{asset('js/jquery.lazyload.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.btn-wish').click(function () {
            $(this).toggleClass('wished');
            $(this).children('.fa').toggleClass('fa-heart-o').toggleClass('fa-heart');
            AddToWishList($(this).data("campaign-id"), $(this).data("user-id"));
        });   
    });
    $(function() {
        $("img.lazy").lazyload({
            threshold : 280,
            effect : "fadeIn",
            event : "sporty",
        });
    });
    $(window).bind("load", function() {
        var timeout = setTimeout(function() {
            $("img.lazy").trigger("sporty")
        }, 2000);
    });
</script>
    
@stop
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
.btn-wish:hover{
    cursor: pointer;
}

@media(max-width: 480px){
    #user-header #about #u-favorite{
        display: none;
    }
}

@media(max-width:320px){
    .product-box .product-img{
        height: 125px;
    }   
}
@media(min-width:321px) and (max-width:385px){
    .product-box .product-img{
        height: 160px;
    }    
}
@media(min-width:386px) and (max-width:420px){
    .product-box .product-img{
        height: 182px;
    }    
}
@media(min-width:421px) and (max-width:480px){
    .product-box .product-img{
        height: 213px;
    }
}

</style>
@stop
@section('content')
<div class="row ">
    <div class="col-sm-12">
        <div class="box-blank">
            <div class="box-body box-product">
                <div class="row">
                    @forelse($campaigns as $campaign)
                        <div class="col-md-3 col-sm-3 col-xs-6 col-mobile">
                            <div class="product-box">
                                <a href="{{ action('CampaignController@showCampaign', $campaign->url) }}">
                                    <div class="product-img">
                                        <img class="lazy" src="{{asset('images/t-holder.png')}}" data-original="{{ action('CampaignController@getFile', [$campaign->id, $campaign->frontCover()]) }}">
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
                        @empty
                        <p class="alert text-center">ยังไม่มีรายการที่ชื่นชอบ</p>
                    @endforelse
                </div>
            </div>
        </div>
   </div>
</div>
@stop