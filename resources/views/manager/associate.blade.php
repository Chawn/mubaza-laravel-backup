@extends('manager.layouts.master')

@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script src="{{asset('js/jquery.countdownTimer.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            var deviceWidth = $(window).width();
            var deviceHeight = $(window).height();

            if (deviceWidth < 767){
                $('#about .container').addClass('container-fullid');
                $('#about .container').removeClass('container');
            }
        });

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           $('#search-input').keyup(function(e) {
               var code = e.which;
               if(code == 13) {
                   window.location = "{{ \Request::url() }}?q=" + $(this).val();
               }
           }) ;

            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });

             var deviceHeight = $(window).height();
             $('.main').css('min-height',deviceHeight-140); 

             $('#countdown').countdowntimer({
                dateAndTime : "2015/12/31 23:59:59",

            });
        });
    </script>
@stop
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/associates.css') }}">
    <link rel="stylesheet" href="{{asset('css/landing.css')}}">
    <style type="text/css" media="screen">
        body{
            background: #f5f5f5;
        }
        
        @media(max-width: 767px){
            #main-container{

            }
            #main-content{

            }
        }
        .content-header{
            display: none;
        }
        .container{
            max-width: 980px;
        }
            
    </style>
        
@stop
@section('cover')
<div id="section-slide" class="carousel slide" data-ride="carousel" style="position:relative;">
    <!--
    <ol class="carousel-indicators">
        <li data-target="#section-slide" data-slide-to="0" class="active"></li>
        <li data-target="#section-slide" data-slide-to="1"></li>
        <li data-target="#section-slide" data-slide-to="2"></li>
    </ol>-->
    <div class="carousel-inner" role="listbox">
        
        <div class="bg-carousel item active" style="background:url('{{ asset('images/hero-header/1.jpg') }}'); background-size:cover;background-position:center center;background-repeat: no-repeat;">
            <div class="hero-warp-1"></div>
            <div class="container  fixnonslide">        
                <div class="jumbotron">
                    <div class="group-hero-header hero-1">
                        <div class="hero-head" >
                            <h1 style="text-shadow:0 2px 5px #555">
                                <strong>
                                    Easy way to Design & Sell Shirts Online.
                                </strong>
                            </h1>
                            <h4 style="text-shadow:0 2px 5px #555">อยากขายเสื้อยืดออนไลน์ ไม่ใช่เรื่องยากอีกแล้ว</h4>
                            <p class="description"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

@stop
@section('content')
<div class="main">
<h2>
    <strong> 
        Why {{ config('profile.sitename') }}?
    </strong>
</h2>
    <div class="row">
        
        <div class="col-sm-6">

            <!--<div class="cover-img">
                <div class="img"></div>                    
            </div>-->
            <img class="full-width" src="{{ asset('images/content/0.jpg') }}" alt="">
        </div>
        <div class="col-md-6">
            <div class="why-mubaza">
                
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>
                                <h4>
                                    <strong>Feature</strong>
                                </h4>
                            </th>
                            <th class="text-center">
                                <h4>
                                    <strong>{{ config('profile.sitename') }}</strong>
                                </h4>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left">
                                <h4>
                                ส่วนแบ่งสูงสุด 25% จากราคาขาย
                                </h4>
                            </td>
                            <td>
                                <i class="fa fa-check text-success"></i>
                            </td>
                            
                        </tr>
                        <tr>
                            <td class="text-left">
                                <h4>
                                    เก็บ Cookie ไว้ 30 วัน
                                </h4>
                            </td>
                            <td>
                                <i class="fa fa-check text-success"></i>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                <h4>
                                สินค้าที่สร้างไม่มีหมดเวลา คงอยู่ตลอดไป
                                </h4>
                            </td>
                            <td>
                                <i class="fa fa-check text-success"></i>
                            </td>
                            
                        </tr>
                        <tr>
                            <td class="text-left">
                                <h4>
                                ลูกค้าติดตามคุณได้บนเว็บไซต์
                                </h4>
                            </td>
                            <td>
                                <i class="fa fa-check text-success"></i>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                <h4>
                                สร้าง Store ได้ เหมือนร้านตัวเอง
                                </h4>
                            </td>
                            <td>
                                <i class="fa fa-check text-success"></i>
                            </td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <h2>
                <strong> 
                    How it Works?
                </strong>
            </h2>
            <img class="full-width" src="{{ asset('images/content/1.jpg') }}" alt="">
        </div>
    </div>
    <hr>
    <div class="row">
        
        <div class="col-md-5 col-sm-12 col-xs-12 pull-right">
            <div id="what-new" class="">
                <div class="box-title">
                    <h2 class="">
                        <strong>News</strong>
                    </h2>
                </div>
               
                <div class="box-content">
                    <div class="list-group">
                        <span class="small text-grey">1 ธันวาคม 2558</span>
                        <h4 class="list-title text-orange"><strong>ยินดีต้อนรับสู่ GG7</strong></h4>
                        <p>
                            GG7 ยินดีต้อนรับครีเอเตอร์และชาว Affiliate ทุกท่าน หากมีข้อสงสยหรือต้องการความช่วยเหลือโปรดติดต่อเราที่
                            <br>www.facebook.com/ggseven.th
                            <br>โทร. {{ config('profile.phone-primary') }}
                        </p>                           
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-7 col-sm-12 col-xs-12">

            <div id="artist" class="">
                <div class="box-title">
                    <h2 class="">
                        <strong>Creator</strong>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="thumbnail-designer thumbnail text-center">
                                <div class="icon">
                                    <i class="fa fa-picture-o fa-3x text-white"></i>
                                </div>
                                <div class="caption text-center">
                                    <h3 class="title text-orange"><strong>1. Design</strong></h3>
                                    <p>ออกแบบลายเสื้อยืด</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="thumbnail-designer thumbnail text-center">
                                <div class="icon">
                                    <i class="fa fa-edit fa-3x text-white"></i>
                                </div>
                                <div class="caption text-center">
                                    <h3 class="title text-orange"><strong>2. Create</strong></h3>
                                    <p>สร้างสินค้าบนเว็บไซต์</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="thumbnail-designer thumbnail text-center">
                                <div class="icon">
                                   <i class="fa fa-money fa-3x text-white"></i>
                                </div>
                                <div class="caption text-center">
                                    <h3 class="title text-orange"><strong>3. Earn</strong></h3>
                                    <p>รับส่วนแบ่งจากทุกๆ การขาย ตลอดไป</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a class="see-more" href="{{ action('AssociateController@getCreator') }}">
                                รายละเอียดทั้งหมด<i class="fa fa-angle-double-right"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <hr>
            <div id="affiliate" class="">
                <div class="box-title">
                    <h2 class="">
                        <strong>Affiliate</strong>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="thumbnail-affiliate thumbnail text-center">
                                <div class="icon">
                                    <i class="fa fa-check-square-o fa-3x text-white"></i>
                                </div>

                                <div class="caption text-center">
                                    <h3 class="title text-orange"><strong>1. Choose</strong></h3>
                                    <p>เลือกสินค้าที่คุณต้องการ จากคลังสินค้าของเรา ซึ่งออกแบบโดยครีเอเตอร์จากทั่วประเทศ</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="thumbnail-affiliate thumbnail text-center">
                                <div class="icon">
                                    <i class="fa fa-share-square-o fa-3x text-white"></i>
                                </div>

                                <div class="caption text-center">
                                    <h3 class="title text-orange"><strong>2. Promote</strong></h3>
                                    <p>นำสินค้าที่คุณเลือกนั้น ไปโฆษณาประชาสัมพันธ์ ไม่ว่าจะเป็นทางโซเชียลมีเดีย หรือเว็บไซต์ก็ได้ทั้งนั้น</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="thumbnail-affiliate thumbnail text-center">
                                <div class="icon">
                                    <i class="fa fa-money fa-3x text-white"></i>
                                </div>

                                <div class="caption text-center">
                                    <h3 class="title text-orange"><strong>3. Earn</strong></h3>
                                    <p>รับรายได้ทันทีเมื่อเกิดการสั่งซื้อภายใน 24 ชั่วโมง โดยไม่หักค่าใช้จ่ายใด ๆ </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a class="see-more" href="{{ action('AssociateController@getAffiliate') }}">รายละเอียดทั้งหมด<i class="fa fa-angle-double-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

</div>
@stop