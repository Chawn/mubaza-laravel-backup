@extends('layouts.campaign')
@section('meta')
    <meta name="description" content="{!! $campaign->title !!}"/>
    <meta property="og:title" content="{{ $title }}"/>
    <meta property="og:type" content="product"/>
    <meta property="og:url" content="{{ Request::url() }}"/>
    <meta property="og:image"
          content="{{ action('CampaignController@getFile', [$campaign->id, $campaign->frontCover()]) }}"/>
    <meta property="og:site_name" content="MUBAZA"/>
    <meta property="fb:admins" content="USER_ID"/>
    <meta property="og:description" content="{{ strip_tags($campaign->description) }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('script')
    <script src="{{ asset('js/jquery.flip.js') }}"></script>
    <script src="{{ asset('js/countdown/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('js/jquery.uploadPreview.js') }}"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#box-timecount").countdown($("#box-timecount").data("end"), function (event) {
                var day = event.strftime('%-D');
                var hour = event.strftime('%-H');
                var minute = event.strftime('%-M');
                var second = event.strftime('%-S');

                var time_left = "";
                if (day > 0) {
                    time_left = day + " วัน ";
                    if (hour > 0) {
                        time_left = time_left + hour + " ชั่วโมง ";
                    } else {
                        if (minute > 0) {
                            time_left = time_left + minute + " นาที ";
                        }

                    }
                } else if (hour > 0) {
                    time_left = hour + " ชั่วโมง ";
                } else if (minute > 0) {
                    time_left = minute + " นาที";
                } else if (second > 0) {
                    time_left = second + " วินาที";
                } else {
                    time_left = 0;
                }

                if (time_left != 0) {
                    $(this).html(time_left);
                } else {
                    $(this).html('0');
                }
            }); 
            $('.btn-wishlist').click(function () {
                $(this).toggleClass('btn-blue');
                $(this).toggleClass('wished');
            });
            $('.flipper').flip({
                trigger: 'manual'
            });
            $('#flip .front').hide();
            $('#flip').click(function () {
                $('.flipper').flip('toggle');
                $('#flip .back').toggle();
                $('#flip .front').toggle();
            });            

            $('.close-see-more').hide();
            $('.see-more').click(function () {
                $('#campaign-detail').addClass('full-detail');
                $('#campaign-detail-text').addClass('full-detail');
                $('#campaign-detail-about').addClass('full-detail');
                $('.see-more').hide();
                $('.close-see-more').show();
            });
            $('.close-see-more').click(function () {
                $('#campaign-detail').removeClass('full-detail');
                $('#campaign-detail-text').removeClass('full-detail');
                $('#campaign-detail-about').removeClass('full-detail');
                $('.close-see-more').hide();
                $('.see-more').show();
                if ($(window).width() >= 992) {
                    $('html, body').animate({
                        scrollTop: $($(this).attr('href')).offset().top - 55
                    }, 500);
                    return false;
                } else {
                    $('html, body').animate({
                        scrollTop: $($(this).attr('href')).offset().top
                    }, 800);
                    return false;
                }

            });
            $('#btn-close-detail').click(function () {
                $('#campaign-detail').slideToggle("slow");
                $(this).toggleClass('close-detail');
                $('#campaign-select').toggleClass('addMargin');
                $('#closedetail').toggleClass('hide');
                $('#showdetail').toggleClass('hide');
                $('#close-detail-group').toggleClass('fixtop');

            });
            function getSize(data) {
                var html_text = "";
                $.each(data.split(','), function (k, v) {
                    html_text += '<a data-size="' + v + '" class="t-size">' + v + '</a>';
                });
                $('#size-chart').html(html_text);
                $(".t-size").click(function () {
                    $(".t-size.size").removeClass("size");
                    $(this).addClass("size");
                });
            }

            $('#btn-zoomin').click(function () {
                $('.zoomTarget').addClass('dragzoom');
                $('.zoomTarget').draggable({
                    disabled: false
                });
            });
            $('#btn-zoomout').click(function () {
                 $('.zoomTarget').removeClass('dragzoom');
                $('.zoomTarget').css({
                    'width': '75'+'%',
                    'position': 'absolute',
                    'left' : '0',
                    'right' : '0',
                    'top' : '0'
                });
                $('.zoomTarget').draggable({
                    disabled: true
                });
            });
            $('.zoomTarget').load(function() {
                var campaignShow = $('#campaign-select-show .zoomTarget').height();
                var imgCarousel = $('#carousel-campaign-related .product-img img').height();
                if ($(window).width() > 992) {
                    $('#campaign-select-show').css({
                        'height': campaignShow+30 + 'px'
                    });
                    $('#carousel-campaign-related .product-img').css({
                        'height': imgCarousel * 70 / 100 + 'px'
                    });
                } else {
                    $('#campaign-select-show').css({
                        'height': campaignShow+30 + 'px'
                    });
                    $('#carousel-campaign-related .product-img').css({
                        'height': imgCarousel * 70 / 100 + 'px'
                    });
                }
            });    
            

            $("#tshirt-type").change(function () {
                selected_item.product_id = $(this).val();
                loadColor($(this).val());
            });

            $('.like-comment').click(function() {
                $(this).toggleClass('default');
                $(this).children('.fa').toggleClass('fa-thumbs-up').toggleClass('fa-thumbs-o-up');
            });


            function baseEvent() {
                var color_select = $(".color-select");

                color_select.unbind('click');

                color_select.click(function () {
                    $('.color-select.color').removeClass('color');
                    $(this).addClass('color');
                    loadAvailableSize($(this).attr("data-color-id"));
                    loadProductImage($(this).attr('data-image-front'), $(this).attr('data-image-back'));
                    selected_item.product_color_id = $(this).attr("data-color-id");
                    selected_item.campaign_product_id = $(this).attr("data-campaign-product-id");
                    selected_item.sell_price = $(this).attr("data-sell-price");
                    updatePrice();
                });

                var size_select = $(".size-select");
                size_select.unbind("click");

                size_select.click(function () {
                    $('.size-select.select').removeClass('select');
                    $(this).addClass('select');

                    selected_item.product_sku_id = $(this).attr("data-sku-id");
                });
            }

            $("#add-to-wish-list").click(function () {
                $.ajax({
                    type: "GET",
                    url: "/campaign/add-to-wish-list/" + campaign.id + "/" + $(this).data("user-id"),
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
            });
            $('#btn-post-comment').click(function () {
                var message = $("#message");
                if (message.val() != "") {
                    message.removeClass('error');
                    $.ajax({
                        type: "POST",
                        url: '/campaign/save-comment',
                        data: {
                            campaign_id: campaign.id,
                            user_id: $(this).data("user-id"),
                            message: message.val()
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.success) {
                                location.reload();
                            }
                        },
                        failure: function (errMsg) {
                            alert(errMsg);
                        }
                    });
                } else {
                    $('#message').addClass("error");
                }
            });

            $("#add-to-cart").click(function () {
                if(!checkItem())
                {
                    return false;
                }

                var cart = null;

                if(store.has('cart'))
                {
                    cart = store.get('cart');
                }

                $.ajax({
                    type: "POST",
                    url: '/order/add-to-cart',
                    data: {
                        cart: cart,
                        item: selected_item
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            store.set('cart', data.cart);
                            $("#modal-cart").modal();
                        }
                        else
                        {
                            console.log(data);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            });

            /*
             Campaign product select
             */
            var campaign = null;

            var campaign_products = null;

            var selected_item = {
                campaign_id: null,
                campaign_product_id: null,
                product_color_id: null,
                product_id: null,
                product_sku_id: null,
                sell_price: null,
                qty: 1
            };

            loadCampaign($("#add-to-cart").data("campaign-id"));

            function loadCampaign(id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/') }}/campaign/available-sku/" + id,
                    dataType: "json",
                    success: function (data) {
                        campaign = data;
                        selected_item.campaign_id = data.id;
                        loadCampaignProduct(data.id);
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            function loadCampaignProduct(id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/') }}/campaign/available-campaign-product/" + id,
                    dataType: "json",
                    success: function (data) {
                        campaign_products = data;
                        loadTShirtType();
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            function loadTShirtType() {
                var tshirt_type = $("#tshirt-type");
                var primary_id = null;
                $.each(campaign_products, function (k, v) {
                    if (v.is_primary) {
                        primary_id = v.product_id;
                    }

                    if (!productExists(v.product_id)) {
                        tshirt_type.append('<option value="' + v.product_id + '">' + v.name + '</option>');
                    }
                });
                tshirt_type.val(primary_id);
                tshirt_type.trigger("change");
            }

            function loadColor(product_id) {
                // Save product_id
                selected_item.product_id = $("#tshirt-type").val();
                var product_colors = $(campaign_products).filter(function () {
                    return this.product_id == product_id;
                });
                var color_panel = $("#color-panel");
                color_panel.html("");
                var selected = "";
                $.each(product_colors, function (k, v) {
                    console.log(v);
                    if (v.is_primary) {
                        selected = "color"
                    }
                    else {
                        selected = "";
                    }

                    color_panel.append('<a class="color-select ' + selected + '" ' +
                            'data-campaign-product-id="' + v.campaign_product_id + '" ' +
                            'data-color-id="' + v.product_color_id + '" ' +
                            'data-image-front="' + v.image_front + '" ' +
                            'data-image-back="' + v.image_back + '" ' +
                            'data-sell-price="' + v.sell_price + '" ' +
                            'style="background-color:' + v.color + '"><i class="fa fa-check"></i></a>');
                });

                baseEvent();
                $(".color-select:first-child").trigger("click");
            }
            function checkItem() {
                if(selected_item.product_sku_id == null)
                {
                    alert("คุณยังไม่ได้เลือกขนาด");
                    return false;
                }

                return true;
            }
            function loadProductImage(image_front, image_back) {
                if(image_front != "") {
                    $("#image-front").attr("src", "{{ url('/') }}/campaign/file/" + campaign.id + "/" + image_front);
                }
                if(image_back != "")
                {
                    $("#image-back").attr("src", "{{ url('/') }}/campaign/file/" + campaign.id + "/" + image_back);
                }
            }

            function loadAvailableSize(color_id) {
                var color = $(campaign.products).filter(function () {
                    return this.product_color_id == color_id;
                })[0].color;
                var size_panel = $("#size-panel");
                size_panel.html("");
                $.each(color.sku, function (k, v) {
                    size_panel.append('<a class="btn size-select m" data-sku-id="' + v.id + '">' + v.size + '</a>');
                });

                baseEvent();
            }

            function updatePrice() {
                $("#price").html(selected_item.sell_price);
            }

            function productExists(id) {
                var result = false;
                $("#tshirt-type option").each(function () {
                    if ($(this).val() == id) {
                        result = true;
                    }
                    if (result) {
                        return false;
                    }
                });

                return result;
            }

            
            $('.btn-edit-cover').click(function() {
                $('.campaign-cover-tools').show();
                $('.group-edit-campaign').hide();
            });

            $('.campaign-cover-tools').css('background','transparent');
            $('.cover-tools-close').click(function() {
                $('.campaign-cover-tools').show();
                $('.campaign-cover-tools').css('background','transparent');
                $('.group-btn-control').hide();
            });
            $('#cover-upload').click(function() {
                $('.campaign-cover-tools').css('background','rgba(0,0,0,0.8)');
            });
            $('.campaign-cover').click(function() {
                $('.campaign-cover-tools').css('background','transparent');
            });

            $.uploadPreview({
                input_field: "#cover-upload",
                preview_box: ".campaign-cover",
                preview_box_img: ".campaign-cover img",
                label_field: "#cover-label"
            });


            if( document.getElementById("cover-upload").files.length == 0 ){
                $('.group-btn-control').hide();
                $('.btn-file').show();
            }else{
                $('.btn-file').hide();
                $('.group-btn-control').show();
            }
        });
            
    </script>
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('css/campaign-show.css') }}">

    <link rel="stylesheet" href="{{ asset('css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('css/btn-social.css') }}">
    <style>
        .hide-detail {
            height: 0px !important;
            transition: all 1s;
        }

        .addMargin {
            margin-top: 52px;
        }

        .hide {
            display: none;
        }

        #unwishlish:hover i {
            color: #F62459;
        }
        .dragzoom{
            width: auto !important;
            cursor: move;
        }
        #footer{
            margin-bottom: 35px;
        }
        @media (max-width: 991px){
            #footer{
                margin-bottom: 0px;
                padding: 0 0 25px 0;
            }
        }
    </style>
@stop
@section('content')
    <section id="section-campaign-cover" class="section">
        <div class="row">
            <div class="col-md-12">
                    <div class="campaign-cover-tools">
                            <div class="btn btn-default btn-file">    
                                <i class="fa fa-file-image-o"></i>                          
                                <label for="cover-upload" id="cover-label">อัพโหลดรูปภาพ</label>
                                <input type="file" id="cover-upload">
                            </div>
                            <div class="group-btn-control">
                                <button class="btn btn-cover btn-primary">save</button>
                                <button class="btn btn-cover btn-default cover-tools-close">close</button>
                            </div>                                                  
                    </div>
                    <div class="campaign-cover">
                        <img src="{{ asset('images/testCover_460.png') }}">
                        <!--
                        <div class="group-edit-campaign">
                            <button class="btn btn-default btn-edit-cover">แก้ไขรูปหน้าปก</button>
                        </div>  
                        -->             
                    </div>   
            </div>
        </div>
    </section>

    <section id="campaign-select" class="section">
        <div class="container container-mobile">
            <div id="title-group" class="col-md-9 col-sm-9 col-xs-12">
                <h1 class="campaign-title">{{ $campaign->title }}</h1>

                <p class="campaign-designer">โดย&nbsp;<a href="#">{{ $campaign->user->getName() }}</a></p>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div id="box-social">
                    @if(\Auth::user()->check())
                        <a id="add-to-wish-list"
                           class="btn-wishlist btn-circle btn-gray {{ \Auth::user()->user()->isAddedToWishList($campaign->id) ? 'wished': '' }}"
                           data-user-id="{{ \Auth::user()->user()->id }}">
                            <i class="fa fa-heart-o"></i>
                        </a>
                    @else
                        <a id="unwishlish" class="btn-circle btn-gray"
                           data-toggle="modal" href="#modal-login">
                            <i class="fa fa-heart-o"></i>
                        </a>
                    @endif
                    <a id="shared" class="btn-circle btn-gray" data-toggle="collapse" href="#box-shared"
                       aria-expanded="false" aria-controls="box-shared">
                        <i class="fa fa-share-alt"></i>
                    </a>                    
                </div>
                <div id="box-shared" class="collapse">
                    <div class="shared-container">
                        <div class="shared-triangle">
                        </div>
                        <div class="shared-in">
                            <a id="facebook" class="btn-shared-social btn-shared-facebook"
                               onclick="popUp=window.open('http://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false"></a>
                            <a class="btn-shared-social btn-shared-googleplus"
                               onclick="popUp=window.open('https://plus.google.com/share?url={{ urlencode(Request::url()) }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false"></a>
                            <a class="btn-shared-social btn-shared-twitter"
                               onclick="popUp=window.open('https://twitter.com/intent/tweet?original_referer={{ urlencode(Request::url()) }}&text={{ $campaign->title }}&tw_p=tweetbutton&url={{ Request::url() }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false"></a>
                            <a class="btn-shared-social btn-shared-pinterest"
                               onclick="popUp=window.open('http://www.pinterest.com/pin/create/button/?url={{ Request::url() }}&media={{ $campaign->frontCover() }}&description={{ $campaign->title }})','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false"></a>
                            <a href="mailto:?subject={{ $campaign->title }}&amp;body={{ urlencode(Request::url()) }}"
                               class="btn-shared-social btn-shared-email"></a>
                        </div>
                    </div>
                </div>
            </div>
                    
            <div class="col-md-7 col-sm-6 col-xs-12">
                <div id="campaign-select-show">
                    <div class="flip-container">
                        <div class="flipper">
                            <div class="front select-img ">
                                <img class="zoomTarget tshirt" id="image-front"
                                     src="{{ action('CampaignController@getFile', [$campaign->id, $campaign->frontCover()]) }}">
                            </div>
                            <div class="back select-img">
                                <img class="zoomTarget" id="image-back"
                                     src="{{ $campaign->backCover() == null ? '' : action('CampaignController@getFile', [$campaign->id, $campaign->backCover()]) }}">
                            </div>
                        </div>
                    </div>
                    <div id="box-tool" class="select-box">
                        <a id="btn-zoomin" class="tools zoom-in">
                            <i class="fa fa-plus"></i>
                        </a>
                        <a id="btn-zoomout" class="tools zoom-out">
                            <i class="fa fa-minus"></i>
                        </a>
                    </div>
                    <div id="flip-tool" class="img-box">
                        <a id="flip" class="tools">
                            <span>
                                <img class="back" src="{{ $campaign->backCover() == null ? '' : action('CampaignController@getFile', [$campaign->id, $campaign->backCover()]) }}">
                                <img class="front" src="{{ action('CampaignController@getFile', [$campaign->id, $campaign->frontCover()]) }}">
                            </span>                            
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-6 col-xs-12">
                <div id="campaign-select-option">
                    <div id="box-select" class="campaign-select-group">
                        <h4 class="campaign-sub-title">เลือกแบบเสื้อ</h4>
                        <select name="" id="tshirt-type" class="form-control">
                        </select>
                    </div>
                    <div id="box-color" class="campaign-select-group">
                        <h4 class="campaign-sub-title">เลือกสีที่ต้องการ </h4>

                        <div id="color-panel"></div>
                    </div>
                    <div id="box-size" class="box-size campaign-select-group">
                        <h4 class="campaign-sub-title">เลือกขนาดเสื้อ</h4>

                        <div id="size-panel"></div>
                    </div>
                    <div id="box-help" class="campaign-select-group">
                        <p>
                            <a data-toggle="modal" href="#modal-tshirt-size">ตารางเปรียบเทียบขนาดเสื้อ</a>
                        </p>
                    </div>
                    @if($campaign->end != null)
                        <div id="box-timecount" data-end="{{ $campaign->end->format('Y/m/d H:i:s') }}">
                            <h3>เหลือเวลา</h3>

                            <h3>2 <span>วัน</span></h3>

                            <h3>23<span>ชั่วโมง</span></h3>

                            <h3>56<span>นาที</span></h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section id="buy-group" class="">
        <div class="container">
            <div class="col-md-12">
                <div class="pull-left">
                    <div id="list-text">
                        <p class="darkblue"><label>สินค้าจะถูกผลิตหลังจากสั่งซื้อไม่เกิน 5 วันทำการ</label></p>

                        <p>ต้องการความช่วยเหลือ โทร {{ config('profile.phone-primary') }}, Line id:{{ config('profile.sitename') }}</p>
                    </div>
                </div>
                <div class="pull-right">
                    <button class="btn btn-success btn-buy" id="add-to-cart" data-campaign-id="{{ $campaign->id }}">หยิบลงตะกร้า
                    </button>
                </div>
                <div class="price pull-right">
                    <h2 class="total">฿<span id="price">0</span></h2>
                </div>
            </div>
        </div>
    </section>

    <section id="section-detail" class="section">
        <div class="container container-mobile">
            <div class="col-md-12 col-tab-mobile">
                <div id="detail-warpper">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#detail" aria-controls="detail" role="tab" data-toggle="tab">รายละเอียดสินค้า</a>
                        </li>
                        <li role="presentation">
                            <a href="#comment" aria-controls="comment" role="tab" data-toggle="tab">ความคิดเห็น&nbsp;({{ $campaign->comments->count() }})</a>
                        </li>
                        <li id="tab-shipping" role="presentation">
                            <a href="#shipping" aria-controls="shipping" role="tab" data-toggle="tab">การจัดส่งสินค้า</a>
                        </li>
                        <li id="tab-warranty" role="presentation">
                            <a href="#warranty" aria-controls="warranty" role="tab" data-toggle="tab">การรับประกันสินค้า</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="detail" role="tabpanel" class="tab-pane fade in active">
                            <div class="tabpanel-header">
                                <h4>รายละเอียดสินค้า</h4>
                            </div>
                            <div class="tabpanel-body">
                                  {{ $campaign->title }}
                            </div>
                        </div>
                        <div id="comment" role="tabpanel" class="tab-pane fade ">
                            <div class="tabpanel-header">
                                <h4>ความคิดเห็น
                                    <select name="q" id="sort-comment" class="pull-right">
                                        <option value="1">ความเห็นยอดนิยม</option>
                                        <option value="1">ความเห็นล่าสุด</option>
                                    </select>
                                </h4>
                            </div>
                            <div class="tabpanel-body">
                                <div class="group-comment">
                                    @forelse($campaign->comments as $comment)
                                        <div class="media">
                                            <div class="media-left">
                                                <a class="img-profile">
                                                    <span style="background-image:url('{{ $comment->user->avatar }}');"> </span>
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <div class="col-md-10">
                                                    <h4 class="media-heading"><a
                                                                href="{{ action('UserController@getIndex', $comment->user->getID()) }}">{{ $comment->user->getName() }}</a>
                                                    </h4>
                                                    <div class="comment-text">
                                                        {{ $comment->message }}
                                                    </div>                                    
                                                    <div class="comment-time">
                                                        <span>{{ $comment->updated_at->format('d/m/Y') }}</span>
                                                    </div>
                                                    <div class="group-like-comment">
                                                        <a class="like-comment default">                                   
                                                            <i class="fa fa-thumbs-o-up"></i>&nbsp;128&nbsp;</span>ถูกใจ
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        No comment.
                                    @endforelse
                                </div>
                                @if(\Auth::user()->check())
                                    <div id="box-comment">
                                        <div class="media">
                                            <div class="media-left">
                                                <a class="img-profile">
                                                    <span style="background-image:url('{{ \Auth::user()->user()->avatar}}');"> </span>
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <div class="input-group">
                                                    <input type="text" name="message" id="message" class="form-control"
                                                           placeholder="แสดงความคิดเห็นของคุณ">
                                                    <span class="input-group-btn">
                                                        <button id="btn-post-comment" data-user-id="{{ \Auth::user()->user()->id }}"
                                                                class="btn btn-primary" type="button">โพส
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p>เข้าสู่ระบบเพื่อแสดงความติดเห็น</p>
                                @endif
                            </div>
                        </div>
                        <div id="shipping" role="tabpanel" class="tab-pane fade ">
                            <div class="tabpanel-header">
                                <h4>การจัดส่งสินค้า</h4>
                            </div>
                            <div class="tabpanel-body">
                                <p class="text-indent">
                                    เราใช้เวลาดำเนินการผลิต<span class="text-red">ไม่เกิน 5 วันทำการ</span> นับตั้งแต่วันที่คุณได้ชำระเงิน ส่วนระยะเวลาที่ใช้ในการจัดส่งนั้น ขึ้นอยู่กับวิธีการจัดส่งที่คุณได้เลือกในขั้นตอนการสั่งซื้อ คือ
                                </p>
                                <ol class="text-tab">
                                    <li>การจัดส่งสินค้าทางไปรษณีย์แบบลงทะเบียน</li>
                                    <li>การจัดส่งสินค้าทางไปรษณียแบบ EMS</li>
                                    <li>การจัดส่งสินค้าผ่านบริษัทขนส่งเอกชน</li>
                                </ol>
                                <p class="text-indent">
                                    (วันเสาร์, วันอาทิตย์ และ วันหยุดนักขัตฤกษ์ ไม่นับเป็นวันทำการ) คุณสามารถตรวจสอบระยะเวลาการจัดส่งของสินค้ารายการนั้นๆได้ ในหน้าประวัติการสั่งซื้อ
                                </p>
                                <img class="img-banner" src="{{asset('images/time-produce_1.png')}}">
                            </div>
                        </div>
                        <div id="warranty" role="tabpanel" class="tab-pane fade ">
                            <div class="tabpanel-header">
                                <h4>การรับประกันสินค้า</h4>
                            </div>
                            <div class="tabpanel-body">
                                <p class="text-indent">
                                    สิ่งสำคัญและเป็นนโยบายอย่างหนึ่งของมูบาซ่า คือ ความพึงพอใจของลูกค้าต่อสินค้าและบริการของเรา ลูกค้าทุกคุณที่สั่งซื้อสินค้าจาก {{ config('profile.sitename') }} จะได้รับสิทธิและการคุ้มครองจากเรา ดังนี้
                                </p>
                                <img class="img-banner" src="{{ asset('images/warranty_01.png') }}">
                                <h4 class="text-indent">
                                    สิทธิในการขอเปลี่ยนสินค้า
                                </h4>
                                <p class="text-indent">
                                    เงื่อนไขในการขอเปลี่ยนสินค้า ได้แก่
                                </p>
                                <ol class="text-tab">
                                    <li>
                                        <b>ได้รับสินค้าผิด</b>&nbsp;เช่น สินค้าไม่ตรงกับแบบที่สั่ง ลายไม่ตรงกับแบบที่สั่ง เป็นต้น
                                    </li>
                                    <li>
                                        <b>สินค้ามีตำหนิ</b>&nbsp;การตัดเย็บผิดรูปทรง ขาด มีลอยเปื้อนของสี ลายสกรีนไม่สมบูรณ์ เป็นต้น อย่างไรก็ตามการขอเปลี่ยนสินค้าต้องดำเนินการภายใน 7 วันหลังจากคุณได้รับสินค้าแล้ว
                                    </li>
                                </ol>
                                <h4 class="text-indent">
                                    สิทธิในการขอคืนเงิน
                                </h4>
                                <p class="text-indent">
                                    เงื่อนไขในการขอคืนเงินเต็มจำนวน ได้แก่
                                </p>
                                <ol class="text-tab">
                                    <li>
                                        <b>ล่าช้าเกินกำหนด</b>&nbsp;ยังไม่ได้รับสินค้านานเกินกว่า 14 วัน นับตั้งแต่วันที่คุณชำระสินค้า
                                    </li>
                                </ol>
                                <p class="text-indent">
                                    โปรดแจ้งความจำนงโดยติดต่อมาที่แผนกลูกค้าสัมพันธ์ได้ที่ 098 101 5050, 098 101 6060 วันจันทร์-วันเสาร์ เวลา 09.00 - 19.00 ปิดทำการวันอาทิตย์ และวันหยุดนักขัตฤกษ์ Email: {{ config('profile.email') }}
                                </p>
                                <h4 class="text-indent">
                                    ส่งสินค้าคืน
                                </h4>
                                <p class="text-indent">
                                    การส่งสินค้าคืนเพื่อเปลี่ยนสินค้า หรือขอรับเงินคืนจะต้องทำการภายใน 7 วันหลังจากที่คุณได้รับสินค้า โดยส่งมาตามที่อยู่ 229/150 ซอย 5 ถ.อุดรดุษฎี ต.หมากแข้ง อ.เมือง จ.อุดรธานี 41000 และโปรดแจ้งความจำนงโดยติดต่อมาที่แผนกลูกค้าสัมพันธ์ได้ที่ 098 101 5050, 098 101 6060 วันจันทร์-วันเสาร์ เวลา 09.00 - 19.00 ปิดทำการวันอาทิตย์ และวันหยุดนักขัตฤกษ์ Email: {{ config('profile.email') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mobile-customercare">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <a href="{{ url('help/production_time') }}">
                                การจัดส่งสินค้า
                                <span class="pull-right">
                                    <i class="fa fa-angle-double-right"></i>
                                </span>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ url('help/warranty') }}">
                                การรับประกันสินค้า
                                <span class="pull-right">
                                    <i class="fa fa-angle-double-right"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!--
    <section id="comment" class="section">
        <div class="container">
            <div class="col-md-7 col-sm-7 col-xs-12">
                <div class="product-detail">
                    <div class="product-detail-header">
                        <h4>รายละเอียดสินค้า</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-4 col-xs-12">
                <div id="header-comment">
                    <h4>ความคิดเห็น
                        <select name="q" id="sort-comment" class="pull-right">
                            <option value="1">ความเห็นยอดนิยม</option>
                            <option value="1">ความเห็นล่าสุด</option>
                        </select>
                    </h4>
                </div>
                <div class="group-comment">
                    @forelse($campaign->comments as $comment)
                        <div class="media">
                            <div class="media-left">
                                <a class="img-profile">
                                    <span style="background-image:url('{{ $comment->user->avatar }}');"> </span>
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="col-md-10">
                                    <h4 class="media-heading"><a
                                                href="{{ action('UserController@getIndex', $comment->user->getID()) }}">{{ $comment->user->getName() }}</a>
                                    </h4>
                                    <div class="comment-text">
                                        {{ $comment->message }}
                                    </div>                                    
                                    <div class="comment-time">
                                        <span>{{ $comment->updated_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="group-like-comment">
                                        <a class="like-comment default">                                   
                                            <i class="fa fa-thumbs-o-up"></i>&nbsp;128&nbsp;</span>ถูกใจ
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        No comment.
                    @endforelse
                </div>
                @if(\Auth::user()->check())
                    <div id="box-comment">
                        <div class="media">
                            <div class="media-left">
                                <a class="img-profile">
                                    <span style="background-image:url('{{ \Auth::user()->user()->avatar}}');"> </span>
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="input-group">
                                    <input type="text" name="message" id="message" class="form-control"
                                           placeholder="แสดงความคิดเห็นของคุณ">
        							<span class="input-group-btn">
        								<button id="btn-post-comment" data-user-id="{{ \Auth::user()->user()->id }}"
                                                class="btn btn-primary" type="button">โพส
                                        </button>
        							</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p>เข้าสู่ระบบเพื่อแสดงความติดเห็น</p>
                @endif
            </div>
        </div>
    </section>
    -->
    <div id="modal-tshirt-size" class="modal fade modal-fullscreen" tabindex="-1" role="dialog"
         aria-labelledby="qrcodeline" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px	solid #ddd;">
                    <h4 class="modal-title">ตารางเปรียบเทียบขนาดเสื้อ</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-4 col-sm-4 mobile-hidden">
                        <img width="100%" src="{{asset('images/default/t-size.png')}}">
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <table class="table-form">
                            <thead>
                            <tr>
                                <th>ขนาด</th>
                                <th>รอบอก(นิ้ว)</th>
                                <th>ความยาว(นิ้ว)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>S</td>
                                <td>32</td>
                                <td>32</td>
                            </tr>
                            <tr>
                                <td>M</td>
                                <td>32</td>
                                <td>32</td>
                            </tr>
                            <tr>
                                <td>L</td>
                                <td>32</td>
                                <td>32</td>
                            </tr>
                            <tr>
                                <td>XL</td>
                                <td>32</td>
                                <td>32</td>
                            </tr>
                            <tr>
                                <td>XXL</td>
                                <td>32</td>
                                <td>32</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer" style="background: #fff;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
@stop