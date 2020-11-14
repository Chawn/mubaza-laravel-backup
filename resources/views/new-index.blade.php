@extends('layouts.index_full_width')
@section('css')
    <link rel="stylesheet" href="{{asset('css/new-index.css')}}">
    <style>
        section{
            margin-bottom: 30px;
        }
        .surprise-result {

        }

        .product-detail {
            background: #fff;
        }

        #timer{
            display: inline-block;
            margin-bottom: auto;
            width: auto;
            margin-top: 30px;
        }
        .flip-clock-divider .flip-clock-label{
            color: #fff;
        }
        #event-section{
            border-top:solid 1px #eee;
            border-bottom:solid 1px #eee; 
            background: #CCC;
            padding: 25px 0 40px 0;
        }
        .b-lazy {
        -webkit-transition: opacity 1500ms ease-in-out;
           -moz-transition: opacity 1500ms ease-in-out;
             -o-transition: opacity 1500ms ease-in-out;
                transition: opacity 1500ms ease-in-out;
                 max-width: 100%;
                   opacity: 0.2;
        }
        .b-lazy.b-loaded {
            opacity: 1;
        }

        @media(max-width: 767px){
            body{
                overflow-x:hidden;
                width:100%;
            }
            .mobile-margin{
                margin-bottom: 15px;
            }
            #section-slide{
                display: block;
            }
        }
        @media(max-width: 320px){
            .mobile-margin{
                width: 90%;
            }
        }
    </style>
@stop

@section('script')
<script src="{{asset('js/jquery.lazyload.js')}}"></script>
<script type="text/javascript">
         $(document).ready(function () {
            $('.bxslider').bxSlider();
            
            $(".product-img").hover(function () {
                $(this).find(".overlay-hidden").addClass('overlay-active');
            }, function () {
                $(this).find(".overlay-hidden").removeClass('overlay-active');
            });


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var windowWidth = $(window).width();
            $('#guide-group-tap').click(function () {
                $('#guide-group-tap').toggleClass('active');
                $('.guide-box.active').not(this).removeClass('active');
                $('#guide-group').toggleClass('show');
                $('#guide-campaign').removeClass('show');
            });
            $('#guide-campaign-tap').click(function () {
                $('#guide-campaign-tap').toggleClass('active');
                $('.guide-box.active').not(this).removeClass('active');
                $('#guide-campaign').toggleClass('show');
                $('#guide-group').removeClass('show');
            });
            $('#btn-design-buy').hide('500');
            $('#btn-create-campaign').hide('500');
            $('#guide-group-mobile').click(function () {
                $('.box-group-mobile').toggleClass('highlight');
                $(this).children('.guide-detail').slideToggle('500');
                $('#btn-design-buy').slideToggle('500');
                $(this).children('.span-chevron').toggleClass('rotate');

            });
            $('#guide-campaign-mobile').click(function () {
                $('.box-campaign-mobile').toggleClass('highlight');
                $(this).children('.guide-detail').slideToggle('500');
                $('#btn-create-campaign').slideToggle('500');
                $(this).children('.span-chevron').toggleClass('rotate');
            });
            $('.btn-wish').click(function () {
                $(this).toggleClass('wished');
                $(this).children('.fa').toggleClass('fa-heart-o').toggleClass('fa-heart');
                AddToWishList($(this).data("campaign-id"), $(this).data("user-id"));
            });
         
            /*$('.product-img img').load(function() {
             var productHeight = $('.product-img img').height();
             $('.product-img').css({
             'height' : (productHeight) + 'px'
             });
             });*/

            function AddToWishList(campaign_id, user_id) {
                $.ajax({
                    type: "GET",
                    url: "/campaign/add-to-wish-list/" + campaign_id + "/" + user_id,
                    dataType: "json",
                    success: function (data) {
                        if (!data.error) {
                            console.log(data);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            /*$("#surprise-btn").click(function() {
             $.ajax({
             type: "POST",
             url: "/campaign/surprise",
             data: {
             category_id: $("#category").val(),
             product_id: $("#product").val(),
             color: $("#color").val()
             },
             dataType: "json",
             success: function (data) {
             if (data.success) {
             console.log(data);
             showSurprise(data);
             }
             },
             failure: function (errMsg) {
             alert(errMsg);
             }
             });
             });

             function showSurprise(data) {
             var element = $(".surprise-result");
             element.find(".price").html(data.product.price)
             }

            var src = "";
            src = "data-src-medium";

            var bLazy = new Blazy({
                breakpoints: [{
                    height: 400 
                }],
                src: src,
                success: function(element){
                    setTimeout(function(){
                    var parent = element.parentNode;
                    parent.className = parent.className.replace(/\bloading\b/,'');
                    }, 200);
                }
            });*/
            $("img.lazy").lazyload({
                /*effect : "fadeIn",*/
               
            });

            $('.campaigns-slider').bxSlider({
                slideWidth: 140,
                minSlides: 1,
                maxSlides: 6,
                slideMargin: 12
            });
        });
       
    </script>
@stop
@section('promote-bar')
    
    {{-- <nav id="main-nav-three">
        <p class="promote-bar text-center">
            <strong>
                ขณะนี้อยู่ในช่วงทดลองใช้งาน
            </strong>
        </p>
    </nav> --}}
   
@stop
@section('content')
    <div id="index-wrapper" class="bg-grey">
        <div class="modal fade" id="video-modal" tabindex="-1" role="dialog" aria-hidden="true"
             aria-labelledby="myModalLabel">
            <div class="modal-dialog">
                <iframe id="video" width="900" height="540" data-dismiss="modal"
                        src="{{ config('constant.youtube_campaign_embed') }}?rel=0&amp;enablejsapi=1&amp;vq=hd720&amp;start=0"
                        frameborder="0" allowfullscreen></iframe>
                <div class="row modal-button-wrapper">
                    <br>
                    <a class="btn btn-success btn-lg" href="{{ action('SellController@getIndex') }}"
                       title="{{ Lang::get('messages.create_campaign') }}">
                        {{ Lang::get('messages.create_campaign') }}
                    </a>
                    <button aria-hidden="true" id="close-video" class="btn btn-inverse btn-lg" data-dismiss="modal">
                        ปิดหน้าต่างนี้
                    </button>
                </div>
            </div>
        </div>
        <section class="space-top-lg-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <h3 class="text-center">
                                    <strong>ค้นหาเสื้อยืดที่คุณต้องการ</strong>
                                </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg" placeholder="Shirts for every moment..">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary btn-lg" type="button">
                                            <i class="fa fa-search"></i> ค้นหา
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row space-top-lg-1">
                            <div class="col-sm-10 col-sm-offset-1 text-center">
                                หมวดหมู่: 
                                &nbsp;
                                <a href="{{ url('search')}}">
                                    ทั้งหมด
                                </a>
                                @foreach(\App\CampaignCategory::active()->get() as $category)
                                    ,&nbsp;<a href="{{ url('/search',  $category->name)}}">
                                        {{ $category->detail }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        <section class="space-top-lg-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-xs-7">
                                <h3>
                                    <strong>สินค้าใหม่</strong>
                                </h3>
                            </div>
                            <div class="col-xs-5">
                                <a href="{{ url('/') }}/search?q=" class="pull-right btn btn-border btn-default">ดูทั้งหมด</a>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($recommends as $recommend)
                                <div class="col-md-3 col-sm-6 col-xs-6">
                                    @include('layouts.include.product-box',['campaign'=> $recommend])
                                </div>
                            @endforeach
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>

        <!--
        <section id="whathot">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-xs-6">
                                <h3>
                                    <strong>Super Hot</strong>
                                </h3>
                            </div>
                            <div class="col-xs-6">
                                <br>
                                <a href="#" class="pull-right btn btn-default">ดูทั้งหมด</a>
                            </div>
                        </div>
                        <div class="row">
                            @for($i=0;$i<16;$i++)
                                <div class="col-sm-3">
                                    @foreach($hots as $hot)
                                        <div class="col-sm-3">
                                        @include('layouts.include.product-box',['campaign'=> $hot])
                                        </div>
                                    @endforeach
                                </div>
                            @endfor
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        <section class="space-top-lg-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <a href="{{ url('/') }}/search" class="btn btn-primary btn-block btn-xl">ดูสินค้าทั้งหมด</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        -->
        
        @if(count($latest_view_campaigns)>=6)
            @include('layouts.include.campaigns-slider',['campaigns'=> $latest_view_campaigns,'title' => 'สินค้าที่เพิ่งเข้าชมล่าสุด'])
        @endif

        


<!--
        <section id="surprice">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">


                        <h2 class="text-surprise text-center">
                            <strong>ตัวเลือกง่ายๆ ให้เราเลือกให้คุณ</strong>
                        </h2><br>

                        <p class="text-center">
                            <a href="{{ action('CampaignController@getSurprise') }}"
                               class="btn btn-warning btn-no-shadow btn-bright btn-lg">
                                <strong>
                                    Surprise Me!
                                </strong>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
-->
        <!--
        ปุ่มวิดีโอ
        <button class="open-video btn btn-lg btn-primary" data-toggle="modal" data-target="#video-modal">ช้อปเลย</button>
        -->
        <script>
            $('.open-video').click(function () {
                new_src = $("#video").attr('src') + "&amp;autoplay=1";
                $("#video").attr('src', new_src);
                toggleVideo();
            })
            $('#close-video').click(function () {
                toggleVideo('hide');
            })
            $('#video-modal').on('hidden.bs.modal', function () {
                toggleVideo('hide');
            });

            function toggleVideo(state) {

                var div = document.getElementById("video-modal");
                var iframe = div.getElementsByTagName("iframe")[0].contentWindow;
                div.style.display = state == 'hide' ? 'none' : '';
                func = state == 'hide' ? 'stopVideo' : 'playVideo';
                iframe.postMessage('{"event":"command","func":"' + func + '","args":""}', '*');
            }
        </script>
    </div>

@stop