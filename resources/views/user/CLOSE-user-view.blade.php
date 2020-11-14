@extends('user.layouts.master')
@section('meta')
    <meta name="description" content="{{ $user->detail }}"/>
    <meta property="og:title" content="{{ $user->option->show_full_name ? $user->full_name : $user->username }}"/>
    <meta property="og:type" content="user"/>
    <meta property="og:url" content="{{ action('UserController@getIndex', $user->getID()) }}"/>
    <meta property="og:image" content="{{ $user->avatar  }}"/>
    <meta property="og:site_name" content="MUBAZA"/>
    <meta property="og:description" content="{{ $user->detail }}"/>
@stop
@section('css')
<style>

</style>
@stop
@section('content')
<div class="product-row">
    @forelse($campaigns as $campaign)
        <div class="col-md-4 col-sm-4 col-xs-6 col-mobile">
            <div class="product-box" onclick="location.href='{{ action('SellController@showCampaign', $campaign->url) }}'">
                <div class="product-img">
                    <img src="{{ url('/') . '/' }}{{ $campaign->back_cover ? $campaign->design->image_back_preview_thmb : $campaign->design->image_front_preview_thmb }}">
                </div>
                <div class="product-detail">
                    <div class="product-name text-left">
                        {{ $campaign->title }}
                    </div>
                    <div class="product-description">
                        <div class="price text-left">
                            <span class="time">{{ $campaign->getRemainTime() }}</span>
                        </div>
                        <div class="sold text-right">
                            {{ $campaign->getSold() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="alert text-center" role="alert">ยังไม่มีแคมเปญที่สร้าง</div>
        </div>
    @endforelse
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <nav class="pull-right">
            {!! str_replace('/?', '?', $campaigns->render()) !!}
        </nav>
    </div>
</div>
@stop