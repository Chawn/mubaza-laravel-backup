@extends('layouts.user_full_width')
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
<div class="row">
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
                        @foreach($campaign_wish_lists as $wish_list)
                            <div class="col-md-3 col-sm-3 col-xs-6 col-mobile">
                                <div class="product-box">
                                    <a href="{{ action('CampaignController@showCampaign', $wish_list->campaign->url) }}">
                                        <div class="product-img">
                                            <img src="{{ action('CampaignController@getFile', [$wish_list->campaign->id, $wish_list->campaign->frontCover()]) }}">
                                        </div>
                                    </a>
                                    <div class="product-detail">
                                        <div class="product-name ">
                                            {{ $wish_list->campaign->title }}
                                        </div>
                                        <div class="product-description ">
											<span class="price">
												฿{{ $wish_list->campaign->primaryPrice() }}
											</span>
											<span class="wish pull-right">
												@if(\Auth::user()->check())
                                                    <a class="btn-wish {{ \Auth::user()->user()->isAddedToWishList($wish_list->campaign->id) ? 'wished': '' }}"
                                                       data-campaign-id="{{ $wish_list->campaign->id }}"
                                                       data-user-id="{{ \Auth::user()->user()->id }}">
                                                        &nbsp;<i class="fa  {{ \Auth::user()->user()->isAddedToWishList($wish_list->campaign->id) ? 'fa-heart': 'fa-heart-o' }} "></i>&nbsp;
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
</div>
@stop