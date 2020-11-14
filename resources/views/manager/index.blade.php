@extends('manager.layouts.master')

@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script>
    </script>
@stop

@section('css')
    <style type="text/css" media="screen">
        .product-img img {
            max-width: 100px;
        }
        /*
        #manager{
            background: #f5f5f5;
        }*/
        .mail {
            box-shadow: 0 0 5px #ccc;
            border: solid 1px #ccc;
            width: 800px;
            max-width: 100%;
            margin: 0 auto;
            padding: 50px;
            font-size: 16px;
        }

        .mail .content {
            padding: 15px 0;
        }
        .thumbnail{
            text-align: center;
            height: 167px;
            padding:15px 0;
            background: #eee; 
        }
        a.thumbnail:hover{
            text-decoration: none;
        }
        a.thumbnail:hover .caption{
            color:#0194c6;

        }
        .thumbnail img{
            width: 40%;
        }
        .thumbnail .caption {
            color:#434243;
            font-size: 16px;
            font-weight: bold;
        }
        @media(max-width: 767px){
            .thumbnail{
                height: 140px;
                padding-top:15px;
            }
        }
    </style>
@stop
@section('content')
<div class="row">
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a class="thumbnail" href="{{ action('AssociateController@getCreate') }}">
            <!-- <img src="{{asset('images/associate/icons/256-smooth-newproduct.png')}}" alt=""> -->
            <i class="fa fa-edit fa-4x text-grey space-top-lg-2 space-lg-2"></i>
            <div class="caption">
                <p>สร้างสินค้าใหม่</p>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a class="thumbnail" href="{{ action('AssociateController@getDesign') }}">
            <!-- <img src="{{asset('images/associate/icons/256-smooth-manytshirt-blue-center.png')}}" alt=""> -->
            <i class="fa fa-cogs fa-4x text-grey space-top-lg-2 space-lg-2"></i>
            <div class="caption">
                <p>สินค้าที่ฉันออกแบบ</p>
            </div>
        </a>
    </div>
    <!--
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a class="thumbnail" href="{{ asset('resources/GG7-Art-Template.psd') }}">
            <img src="{{asset('images/associate/icons/256-smooth-download-template.png')}}" alt="">
            <div class="caption">
                <p>ดาวน์โหลด Art Template</p>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a class="thumbnail" href="{{ asset('resources/GG7-Mockup.psd') }}">
            <img src="{{asset('images/associate/icons/256-smooth-mockup.png')}}" alt="">
            <div class="caption">
                <p>ดาวน์โหลด Mockup Template</p>
            </div>
        </a>
    </div>
    -->
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a class="thumbnail" href="{{ action('AssociateController@getGenerateLink') }}">
            <!-- <img src="{{asset('images/associate/icons/256-smooth-createlink.png')}}" alt=""> -->
            <i class="fa fa-share-square-o fa-4x text-grey space-top-lg-2 space-lg-2"></i>
            <div class="caption">
                <p>สร้างลิงค์สินค้า</p>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a class="thumbnail" href="{{ action('AssociateController@getCurrentCommission') }}">
            <!-- <img src="{{asset('images/associate/icons/256-smooth-linechart.png')}}" alt=""> -->
            <i class="fa fa-money fa-4x text-grey space-top-lg-2 space-lg-2"></i>
            <div class="caption">
                <p>รายได้ปัจจุบัน</p>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a class="thumbnail" href="{{ action('AssociateController@getSellReport') }}">
            <!-- <img src="{{asset('images/associate/icons/256-smooth-tshirtwithlamp-blue.png')}}" alt=""> -->
            <i class="fa fa-bar-chart fa-4x text-grey space-top-lg-2 space-lg-2"></i>
            <div class="caption">
                <p>รายงานยอดขาย Creator</p>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a class="thumbnail" href="{{ action('AssociateController@getAffiliateReport') }}">
            <!-- <img src="{{asset('images/associate/icons/256-smooth-speaker.png')}}" alt=""> -->
            <i class="fa fa-bar-chart fa-4x text-grey space-top-lg-2 space-lg-2"></i>
            <div class="caption">
                <p>รายงานยอดขาย Affiliate</p>
            </div>
        </a>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-6">
        <a class="thumbnail" href="{{ action('AssociateController@getBankAccount') }}">
            <!-- <img src="{{asset('images/associate/icons/256-smooth-bookbank.png')}}" alt=""> -->
            <i class="fa fa-credit-card fa-4x text-grey space-top-lg-2 space-lg-2"></i>
            <div class="caption">
                <p>บัญชีธนาคาร</p>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a class="thumbnail" href="{{ action('AssociateController@getProfileSetting') }}">
            <!-- <img src="{{asset('images/associate/icons/256-smooth-user.png')}}" alt=""> -->
            <i class="fa fa-user fa-4x text-grey space-top-lg-2 space-lg-2"></i>
            <div class="caption">
                <p>โปรไฟล์</p>
            </div>
        </a>
    </div>
</div>
@stop