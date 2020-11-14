@extends('layouts.full_width')
@section('content')
    <div id="welcome-page">
        <div id="welcome-1" class="welcome">
            <div class="row">
                <div class="col-md-5">
                    <img src="{{ asset('images/shirts/mubaza.jpg') }}" >
                </div>
                <div class="col-md-7 text">
                    <h1 class="title">ออกแบบเสื้อยืดของคุณได้แล้ววันนี้</h1>
                    <p class="description">เสื้อยืดสกรีนคุณภาพสูง พร้อมบริการจัดส่งถึงบ้าน!!</p><br>
                    <p>
                        <a class="btn btn-success btn-lg btn-medium" href="{{ url('design') }}" role="button">เริ่ม</a> 
                    </p>
                </div>
            </div>
        </div>
        <div id="recommend">
            <div class="text">
                <h2 class="title text-bold">สินค้ายอดนิยม</h2>
                <div class="row">
                @foreach($campaigns as $campaign)
                        <div class="col-md-4 text-center">
                            <div class="wrapper product column">
                                <div class="picture">
                                    <a href="{{ action('SellController@showCampaign', $campaign->url) }}"><img src="{{ $campaign->back_cover ? $campaign->image_back_preview : $campaign->image_front_preview }}" alt="{{ $campaign->title }}" width="230"></a>
                                </div>
                                <div class="status">
                                    <div class="text column pull-left">
                                        ขายแล้ว {{ $campaign->totalOrder() }}/{{ $campaign->goal }}
                                    </div>
                                    <div class="text column text-right pull-right">
                                        เหลือเวลาอีก {{ $campaign->end->diffForHumans(null, true) }} วัน
                                    </div>
                                </div>
                                <br>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $campaign->totalOrder() }}" aria-valuemin="0" aria-valuemax="{{ $campaign->goal }}" style="width:{{ $campaign->orderPercentage() }}%">
                                    </div>
                                </div>
                                <div class="product-name">
                                    <a href="{{ action('SellController@showCampaign', [$campaign->url]) }}">{{ $campaign->title }}</a>
                                </div>
                            </div>
                        </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
<!-- end PAGE -->
@stop