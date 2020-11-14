@extends('backend.layouts.master')
@section('css')
    <style>
        .count {
            font-family: 'supermarket';
            font-size: 36px;
            color: #e67e22;
            margin: 0px;
        }

        .media {
            background: #f1f1f1;
            padding: 10px;
            box-shadow: 2px 2px 0px #989898;
            margin-bottom: 15px;
        }
        .media-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #fff;
            display: inline-block;
        }
        .media-object {
            height: 38px;
            width: 38px;
            margin: 6px;

        }
        .media-body {
            text-align: center;
        }
        .media-title {
            font-family: 'supermarket';
            font-size: 16px;
            color: #555;
            margin: 0px;
        }
        .media-here {
            background: #1abc9c;
            color: #fff;
            box-shadow: 0px 0px 0px;
        }
        .media-here p {
            color: #f1f1f1;
        }
        .media-here h2 {
            color: #f1f1f1;
        }

        .info-box-text {
          text-transform: uppercase;
          font-size: 16px;
          color: #777;
          padding: 5px 0;
        }
        .info-box-icon{
        }
        .product-image img{
            max-width: 100%;
        }
    </style>
@stop
@section('script')
    <script>
        $(document).ready(function () {
            $(".media").click(function() {
                $(".media.media-here").removeClass("media-here");
                $(this).addClass("media-here");
            });
        });
        jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
        $(document).ready(function () {
            $("#group-campaign-must").hide();
            $("#group-mail").hide();
            $("#group-payment").hide();
            $("#group-report").hide();
            $("#menu-wait").click(function () {
                $("#group-campaign-wait").show();
                $("#group-campaign-must").hide();
                $("#group-mail").hide();
                $("#group-payment").hide();
                $("#group-report").hide();
            });
            $("#menu-most").click(function () {
                $("#group-campaign-wait").hide();
                $("#group-campaign-must").show();
                $("#group-mail").hide();
                $("#group-payment").hide();
                $("#group-report").hide();
            });
            $("#menu-mail").click(function () {
                $("#group-campaign-wait").hide();
                $("#group-campaign-must").hide();
                $("#group-mail").show();
                $("#group-payment").hide();
                $("#group-report").hide();
            });
            $("#menu-payment").click(function () {
                $("#group-campaign-wait").hide();
                $("#group-campaign-must").hide();
                $("#group-mail").hide();
                $("#group-payment").show();
                $("#group-report").hide();
            });
            $("#menu-report").click(function () {
                $("#group-campaign-wait").hide();
                $("#group-campaign-must").hide();
                $("#group-mail").hide();
                $("#group-payment").hide();
                $("#group-report").show();
            });
        });

    </script>
@stop
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">สินค้ารอการตรวจสอบ</h3>
            </div>
            <div class="box-body">
                @forelse($checking_campaigns as $campaign)
                    <div class="col-sm-3">
                        @include('backend.campaign.product-box',['campaign'=>$campaign])
                    </div>
                @empty
                    ไม่มีรายการแคมเปญรอตรวจสอบ
                @endforelse
            </div>
        </div>
        
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">แจ้งโอนเงินใหม่</h3>
            </div>
            <div class="box-body">
                
            </div>
        </div>
    </div>
</div>
    
    
@stop