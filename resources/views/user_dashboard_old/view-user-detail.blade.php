@extends('layouts.full_width')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.fs.dropper.min.css') }}">
<style type="text/css">
    #box {
        min-height: 550px;
        margin-bottom: 80px;
    }
    #box-user-detail {
        width: 100%;
        min-height: 450px;
        margin-bottom: 30px;
    }
    #user-img {

        height: 200px;
        border-radius: 50%;
        text-align: center;
    }
    #user-img img {
        max-width: 200px;
        border-radius: 50%;
        text-align: center;
    }
    #user-detail {
        text-align: center;
    }
    #user-detail i {
        margin: 0 5px 0 0px;
    }
    #user-social {
        margin: 15px 0 0 0px;
        width: 300px;
        text-align: center;
    }
    #user-social a {
        text-align: center;
    }
    .btn-social {
        width: 200px;
        margin: 10px 0 0 0;
        vertical-align: middle;
    }
    .btn-social:active {
        box-shadow:none;
    }

    .icon-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        padding: 7px 0 0 0 ;
        display: inline;
        float: left;
        text-align: center;
    }
    .social-link {
        float: left;
        height: 30px;
        width: 150px;
        padding: 4px 0 0 10px;
        text-overflow: '...';

    }

    #group-facebook {
    }

    .facebook {
        color: #1352a2;
        border: 1px solid #1352a2;
        border-bottom: 2px solid #0f4588;
    }
    .facebook:active {
        background: #fff;
        border: 1px solid #1352a2;
    }
    .facebook:hover {
        color: #0f4588;
    }
    .line {
        border:1px solid #00c300;
        border-bottom: 2px solid #02a902;
        color: #00c300;
    }
    .line:active {
        border:1px solid #00c300;
    }
    .line:hover {
        color: #02a902;
    }
    .twitter {
        border: 1px solid #5ea9dd;
        border-bottom: 2px solid #5395c3;
        color: #5ea9dd;
    }
    .twitter:active {
        border: 1px solid #5ea9dd;
    }
    .twitter:hover {
        color: #5395c3;
    }
    .home {
        border:1px solid #8f8f8f;
        border-bottom: 2px solid #757575;
        color: #202020;
    }
    .home:active {
        border:1px solid #8f8f8f;
    }
    .home:hover {
        color: #202020;
    }



    /*col right*/
    #box-campaign {
        min-height: 450px;
        margin-bottom: 30px;
        border-left: 1px solid #ddd;
        padding: 0 0 0 15px;
    }

    #box-pagination {
        width: 100%;
        text-align: center;
        margin: 15px 0 0 0;
    }
    .paging-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #ddd;
        text-align: center;
        color: #fff;
        font-size: 30px;
        font-weight: bold;
        padding-top: 7px;
        margin: 0 10px 0 0;
    }
    .paging-circle i {
        color: #fff;
    }
    .paging-circle:hover {
        background: #ccc;
    }
    .box-social {
        height: 45px;
    }



    /* modal*/
    .modal-dialog {
        background: #fff;
        border-radius: 5px;
    }
    .modal-header {
        border-radius: 5px 5px 0 0;
    }
    .modal-body {
        text-align: center;
    }
    .modal-body img {
        width: 150px;
    }
</style>
@stop

@section('content')
<div id="box">
    <div class="col-md-4">
        <div id="box-user-detail">
            <div id="user-img">
                <img src="{{ $user->avatar }}">
            </div>
            <div id="user-detail">
                <h3>{{ $user->full_name }}</h3>
                <p class="p-detail">{{ $user->description }}</p>
                <p class="user-email"><i class="fa fa-envelope-o"></i>&nbsp;{{ $user->email }}</p>
                <p class="user-email"><i class="fa fa-phone"></i>&nbsp;{{ $user->profile->phone }}</p>
            </div>
            <div id="user-social">
                <div class="box-social">
                    <a class="btn btn-social facebook" href="http://www.facebook.com" target="_blank">
                        <span></span>facebook
                    </a>
                </div>
                <div class="box-social">
                    <a class="btn btn-social line" data-target="#modal-qrcodeline" data-toggle="modal">
                        <span>Line</span>
                    </a>
                </div>
                <div class="box-social">
                    <a class="btn btn-social twitter" href="http://www.twitter.com" target="_blank">
                        <span></span>Twitter
                    </a>
                </div>
                <div class="box-social">
                    <a class="btn btn-social home" href="#" target="_blank">
                        <span>Website</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div id="box-campaign">
            <h3>แคมเปญของฉัน</h3>
            <div class="row">
                @foreach($campaigns as $campaign)
                <div class="col-md-4 col-xs-12">
                    <div class="search-box" onclick="location.href='{{ action('SellController@showCampaign', $campaign->url) }}'">
                        <div class="search-img">
                            <img src="{{ $campaign->image_front_preview }}">
                        </div>
                        <div class="search-name">{{ $campaign->title }}</div>
                        <div class="search-detail">
                            <p data-toggle="tooltip" data-placement="top" title="สั่ง/เป้า"><i class="fa fa-shopping-cart"></i>&nbsp;{{ $campaign->totalOrder() }}/{{ $campaign->goal }}</p>
                            <p data-toggle="tooltip" data-placement="top" title="เหลือเวลา"><i class="fa fa-clock-o"></i>&nbsp;{{ $campaign->getRemainTime() }}</p>
                            <p data-toggle="tooltip" data-placement="top" title="ชื่นชอบ"><i class="fa fa-thumbs-o-up"></i> 123</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div id="box-pagination">
                {!! str_replace('/?', '?', $campaigns->render()) !!}
                {{--<a class="previous" href="#"><i class="fa fa-angle-left paging-circle"></i></a>--}}
                {{--<a class="next" href="#"><i class="fa fa-angle-right paging-circle"></i></a>--}}
            </div>
        </div>
    </div>

    <div id="modal-qrcodeline" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="qrcodeline" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-header">
                <h4 class="modal-title">QR Code ไลน์</h4>
            </div>
            <div class="modal-body">
                <img src="{{ asset('images/aeqr_n.jpg') }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">บันทึก QR Code</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
            </div>

        </div>
    </div>

</div>
@stop