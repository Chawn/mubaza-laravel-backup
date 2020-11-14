@extends('layouts.campaign')
@section('meta')
    <meta name="description" content="{!! $campaign->title !!}"/>
    <meta property="fb:app_id" content="480939195268680"/>
    <meta property="og:title" content="{{ $title }}"/>
    <meta property="og:type" content="product"/>
    <meta property="og:url" content="{{ Request::url() }}"/>
    <meta property="og:image"
          content="{{ action('CampaignController@getFile', [$campaign->id, $campaign->frontCover()]) }}"/>
    <meta property="og:site_name" content="GG7"/>
    <meta property="fb:admins" content="chawput"/>
    <meta property="og:description" content="{{ strip_tags($campaign->description) }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
<?php
$base_url = '/mubaza-laravel/public'
?>
@section('script')
    <script src="{{ asset('js/jquery.flip.js') }}"></script>
    <script src="{{ asset('js/countdown/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('js/jquery.uploadPreview.js') }}"></script>
    <script src="{{ asset('js/jquery.webui-popover.js') }}"></script>
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
                    'width': '75' + '%',
                    'position': 'absolute',
                    'left': '0',
                    'right': '0',
                    'top': '0'
                });
                $('.zoomTarget').draggable({
                    disabled: true
                });
            });
            $('.zoomTarget').load(function () {
                var campaignShow = $('#campaign-select-show .zoomTarget').height();
                var imgCarousel = $('#carousel-campaign-related .product-img img').height();
                if ($(window).width() > 992) {
                    $('#campaign-select-show').css({
                        'height': campaignShow + 'px'
                    });
                    $('#carousel-campaign-related .product-img').css({
                        'height': imgCarousel * 70 / 100 + 'px'
                    });
                } else {
                    $('#campaign-select-show').css({
                        'height': campaignShow + 'px'
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

            $('.like-comment').click(function () {
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
//                            console.log(data);
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
                if (!checkItem()) {
                    return false;
                }

                var cart = null;

                if (store.has('cart')) {
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
                        else {
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

            loadCampaign($("#campaign-id").val());

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
//                    console.log(v);
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
                if (selected_item.product_sku_id == null) {
                    alert("คุณยังไม่ได้เลือกขนาด");
                    return false;
                }

                return true;
            }

            function loadProductImage(image_front, image_back) {
                if (image_front != "") {
                    $("#image-front").attr("src", "{{ url('/') }}/campaign/file/" + campaign.id + "/" + image_front);
                }
                if (image_back != "") {
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


            $('.btn-edit-cover').click(function () {
                $('.campaign-cover-tools').show();
                $('.group-edit-campaign').hide();
            });

            $('.campaign-cover-tools').css('background', 'transparent');
            $('.cover-tools-close').click(function () {
                $('.campaign-cover-tools').show();
                $('.campaign-cover-tools').css('background', 'transparent');
                $('.group-btn-control').hide();
            });
            /*
             $('#cover-upload').click(function () {
             $('.campaign-cover-tools').css('background', 'rgba(0,0,0,0.8)');
             });
             $('.campaign-cover').click(function () {
             $('.campaign-cover-tools').css('background', 'transparent');
             });

             $.uploadPreview({
             input_field: "#cover-upload",
             preview_box: ".campaign-cover",
             preview_box_img: ".campaign-cover img",
             label_field: "#cover-label"
             });


             if (document.getElementById("cover-upload").files.length == 0) {
             $('.group-btn-control').hide();
             $('.btn-file').show();
             } else {
             $('.btn-file').hide();
             $('.group-btn-control').show();
             }*/

            $('a.show-pop').webuiPopover({
                constrains: 'horizontal',
                trigger: 'click',
                title: 'เสื้อยืด Gildan แบรนด์มาตรฐานจากอเมริกา',
                content: '<p><strong>เนื้อผ้า Cotton 100% นุ่ม อ่อนโยนต่อผิว ระบายอากาศได้ดี</strong></p>',
                multi: true,
                closeable: false,
                style: '',
                delay: 300,
                padding: true,
                backdrop: false
            });

            $(".like-comment").click(function() {
                var element = $(this);
                likeComment(element);
            });

            function likeComment(element) {
                $.ajax({
                    type: "GET",
                    url: '/campaign/like-comment',
                    data: {
                        comment_id: element.data("comment-id"),
                        user_id: element.data("user-id")
                    },
                    dataType: "json",
                    success: function (data) {
                        if (!data.success) {
                            console.log(data.message);
                        } else {
                            refreshCountCommentLike(element);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            function refreshCountCommentLike(element) {
                $.ajax({
                    type: "GET",
                    url: "/campaign/comment-like-count",
                    data: {
                        comment_id: element.data("comment-id")
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        if (!data.success) {
                            console.log(data.message);
                        } else {
                            var parent = element.closest("div.group-like-comment");
                            console.log(parent);
                            parent.find("span.like-count").html(data.count);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            $(".delete-comment").click(function() {
                var result = confirm("คุณต้องการลบความคิดเห็นนี้?");
                if(result) {
                    deleteComment($(this));
                }
            });

            function deleteComment(element) {
                $.ajax({
                    type: "GET",
                    url: '/campaign/delete-comment',
                    data: {
                        comment_id: element.data("comment-id"),
                        user_id: element.data("user-id")
                    },
                    dataType: "json",
                    success: function (data) {
                        if (!data.success) {
                            console.log(data.message);
                        } else {
                            element.closest("div.media").remove();
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }
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
                },
                error: function(element, msg) {
                    console.log(msg);
                }
            });
        });

    </script>
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('css/campaign-show.css') }}">

    <link rel="stylesheet" href="{{ asset('css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('css/btn-social.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.webui-popover.css') }}">
    <style>
        body {
            background-color: #f5f5f5;
        }

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

        .dragzoom {
            width: auto !important;
            cursor: move;
        }

        #footer {
            margin-bottom: 35px;
        }

        .help-block {

            color: #5cb85c;
            margin-left: 0px;
            margin-top: -8px;
        }

        #price {
            font-size: 36px;
        }

        #pricetext {
            font-size: 14px;
            margin-left: 8px;
        }

        .column {
            padding: 8px;
        }

        @media (max-width: 991px) {
            #footer {
                margin-bottom: 0px;
                padding: 0 0 25px 0;
            }

            #add-to-cart-and-checkout {
                margin-bottom: 8px;
                width: 100%;
            }
        }

        .alert-tool {
            margin-bottom: 0;
        }

    </style>
    @stop
    @section('content')
            <!--
    <section id="section-campaign-cover" class="section hide">
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
                    
                    <div class="group-edit-campaign">
                        <button class="btn btn-default btn-edit-cover">แก้ไขรูปหน้าปก</button>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
-->
    <input type="hidden" id="campaign-id" value="{{ $campaign->id }}">
    @if(\Auth::user()->check())
        @if(Auth::user()->user()->id==$campaign->user_id)
            <section id="owner-tool">
                <div class="container">
                    <div class="alert alert-info alert-tool">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <h3>เครื่องมือสำหรับครีเอเตอร์</h3>
                        <p>คุณเป็นเจ้าของสินค้านี้ คุณสามารถจัดการสินค้าของคุณด้วยเครื่องมือเหล่านี้</p>
                        <br>
                        <a href="{{ action('AssociateController@getEditCampaign', $campaign->id) }}"
                           class="btn btn-default btn-bright">
                            <i class="fa fa-pencil"></i> แก้ไขรายละเอียด
                        </a>
                        @if($campaign->status->name == 'close')

                            <a href="{{ action('CampaignController@getOpen', $campaign->id) }}"
                               class="btn btn-default btn-warning" id="close-campaign">
                                <i class="fa fa-repeat"></i> เปิดการขายอีกครั้ง
                            </a>

                        @endif
                        @if($campaign->status->name == 'open')

                            <a href="{{ action('CampaignController@getClose', $campaign->id) }}"
                               class="btn btn-default btn-warning" id="close-campaign">
                                <i class="fa fa-times"></i> ปิดการขายชั่วคราว
                            </a>

                        @endif
                    </div>
                </div>
            </section>
        @endif
    @endif
    <section id="campaign-select" class="section">
        <div class="container">
            <div class="wrapper wrapper-white wrapper-content">
                <div class="row">
                    <div class="col-md-7 col-sm-6 nonpading-mobile">
                        <div id="campaign-select-show">
                            <div class="flip-container">
                                <div class="flipper">
                                    <div class="front select-img ">
                                        <img class="zoomTarget tshirt" id="image-front"
                                             src="{{ action('CampaignController@getFile', [$campaign->id, $campaign->frontCover()]) }}">
                                    </div>
                                    <div class="back select-img">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="">รหัสสินค้า: <strong>{{ $campaign->id }}</strong></p>
                        <div class="share-tool">
                            <span class="pull-left">
                                <small>แชร์:</small>
                            </span>
                            <div class="social-share-tool">
                                <ul class="list-inline list-unstyled">
                                    <li>
                                        <a href="#" class="i-share-facebook"></a>
                                    </li>
                                    <li>
                                        <a href="#" class="i-share-google"></a>
                                    </li>
                                    <li>
                                        <a href="#" class="i-share-twitter"></a>
                                    </li>
                                    <li>
                                        <a href="#" class="i-share-pinterest"></a>
                                    </li>
                                    <li>
                                        <a href="#" class="i-share-email"></a>
                                    </li>
                                </ul>
                                <!--<p><small>เข้าสู่ระบบแล้วแชร์จะได้รับแต้ม และเปลี่ยนเป็นคูปองส่วนลดได้</small></p>-->
                            </div>
                        </div>
                        <br>


                    </div>
                    <div class="col-md-5 col-sm-6 nonpading-mobile">
                        <div class="">
                            <div id="title-group">
                                <p class="campaign-title">
                                    <strong>{{ $campaign->title }}</strong>
                                </p>

                            </div>
                            <p class="campaign-designer">
                                ออกแบบโดย&nbsp;<a class="text-grey"
                                                  href="{{ action('UserController@getCreatorShow',$campaign->user->getID()) }}">{{ $campaign->user->getName() }}</a>
                            </p>

                        </div>
                        <hr>
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
                        <div class="select-product-wrapper">
                            <div class="row space-1">
                                <label class="col-sm-3 ">แบบเสื้อ</label>
                                <div class="col-sm-9">
                                    <select name="tshirt-type" id="tshirt-type" class="form-control column"
                                            style="width:90%;">
                                    </select>
                                    <a href="#" data-animation="pop" data-placement="vertical" class="show-pop column"
                                       data-content=""><i class="fa fa-question-circle"></i></a>
                                </div>
                            </div>
                            <div class="row space-1">
                                <label class="col-sm-3 ">สี</label>
                                <div class="col-sm-9">
                                    <div id="color-panel"></div>
                                </div>
                            </div>
                            <div class="row space-1">
                                <label class="col-sm-3 ">ขนาดเสื้อ</label>
                                <div class="col-sm-9">
                                    <div class="box-size">
                                        <div id="size-panel"></div>
                                        <p></p>
                                        <a class="text-grey" style="padding:5px 0;" data-toggle="modal"
                                           href="#modal-tshirt-size">
                                            ตารางเปรียบเทียบขนาด
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @if($campaign->end != null)
                                <div class="row space-1">
                                    <label class="col-sm-3 ">เหลือเวลา</label>
                                    <div class="col-sm-9">
                                        <div id="box-timecount" data-end="{{ $campaign->end->format('Y/m/d H:i:s') }}">
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row space-1">
                                <label class="col-sm-3  space-top-2">ราคา</label>
                                <div class="col-sm-9">
                                    <strong class="" id="price"></strong><span id="pricetext">บาท/ตัว</span>
                                </div>
                            </div>
                            <div class="row space-1">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <p class="help-block">มีสินค้าพร้อมส่ง</p>
                                </div>
                            </div>
                            <div class="row space-1">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button class="btn btn-danger btn-xl" onclick="alert('ส่วนนี้ยังไม่พร้อมใช้งาน');">
                                        <i class="fa fa-shopping-cart"></i> หยิบใส่รถเข็น
                                    </button>
                                </div>
                            </div>
                            <div class="row space-1">
                                <div class="col-sm-9 col-sm-offset-3">
                                    @if(\Auth::user()->check())
                                        <a id="add-to-wish-list"
                                           class="wish text-grey {{ \Auth::user()->user()->isAddedToWishList($campaign->id) ? 'wished': '' }}"
                                           data-user-id="{{ \Auth::user()->user()->id }}" href="#">
                                            <i class="fa fa-heart-o"></i> เพิ่มในรายการโปรด
                                        </a>
                                    @else
                                        <a id="unwishlish" class="wish text-grey"
                                           data-toggle="modal" href="#modal-login">
                                            <i class="fa fa-heart-o"></i> เพิ่มในรายการโปรด
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="row space-1">
                                <label class="col-sm-3 ">การจัดส่ง</label>
                                <div class="col-sm-9">
                                    <p class="space-top-1">
                                        <i class="fa fa-truck"></i> จัดส่ง EMS ระยะเวลา 1-5 วัน
                                    </p>
                                </div>
                            </div>
                            <div class="row space-1">
                                <label class="col-sm-3 ">การรับประกัน</label>
                                <div class="col-sm-9">
                                    <p class="space-top-1">
                                        <i class="fa fa-thumbs-o-up"></i> เปลี่ยนสินค้าภายใน 10 วัน
                                    </p>
                                </div>
                            </div>
                            <div class="row space-1">
                                <label class="col-sm-3 ">โทรสั่ง</label>
                                <div class="col-sm-9">
                                    <p class="space-top-1">
                                        <i class="fa fa-phone"></i> {{ config('profile.phone-primary') }}
                                    </p>
                                </div>
                            </div>
                            <div class="row space-1">
                                <div class="col-sm-12">
                                    <div class="warranty">
                                        <i class="fa fa-thumbs-o-up"></i> รับประกันความพึงพอใจ 100%
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div id="campaign-select-option">
                            <div id="box-select" class="campaign-select-group">
                                <strong class="campaign-sub-title">แบบเสื้อ</strong>
                                <select name="" id="tshirt-type" class="form-control">
                                </select>
                            </div>
                            <div id="box-color" class="campaign-select-group">
                                <strong class="campaign-sub-title">สี</strong>

                                <div id="color-panel"></div>
                            </div>
                            <div id="box-size" class="box-size campaign-select-group">
                                <strong class="campaign-sub-title">
                                    ขนาดเสื้อ
                                </strong>
                                <div id="size-panel"></div>
                                <p></p>
                                    <a href="#" style="padding:5px 0;" data-toggle="modal" href="#modal-tshirt-size">
                                        <small>ตารางเปรียบเทียบขนาด</small>
                                    </a>
                                
                            </div>
                            <div id="box-help" class="campaign-select-group">
                                <p>
                                   
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

                                <div id="buy-group">
                                    <div class="price hide">
                                        <h3 class="total">฿<span id="price">0</span></h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5">
                                            <button class="btn btn-warning btn-xl btn-block" id="add-to-cart" data-campaign-id="{{ $campaign->id }}">
                                    <strong>สั่งซื้อเลย</strong>
                                    </button><br>
                                </div>  
                                <div class="col-sm-12 col-md-7">
                                    <button class="btn btn-success btn-xl btn-block" id="add-to-cart" data-campaign-id="{{ $campaign->id }}">
                                        <strong><i class="fa fa-shopping-cart"></i> หยิบใส่ตระกร้า</strong>
                                    </button>
                                </div>
                                
                                
                            </div>
                        </div>
                        -->
                    </div>

                </div>
                <hr>
                <p class="text-grey">สงวนลิขสิทธิ์งานออกแบบ &copy; {{ $campaign->user->getName() }}</p>

            </div>
        </div>
    </section>

    <section id="section-detail" class="section">
        <div class="container container-mobile">
            <div class="wrapper wrapper-white wrapper-content">
                <div class="row">
                    <div class="col-md-12 col-tab-mobile">
                        <div id="detail-warpper">
                            <h4>
                                <strong>รายละเอียดจากครีเอเตอร์</strong>
                            </h4>

                            <div class="tab-content">
                                <div id="detail" role="tabpanel" class="tab-pane fade in active">
                                    <div class="tabpanel-body">
                                        {!! $campaign->description !!}
                                    </div>
                                </div>
                                <div id="shipping" role="tabpanel" class="tab-pane fade ">
                                    <div class="tabpanel-body">
                                        <p class="text-indent">
                                            เราใช้เวลาดำเนินการผลิต 1 - 5 วันทำการ
                                            นับตั้งแต่วันที่คุณได้ชำระเงิน ส่วนระยะเวลาที่ใช้ในการจัดส่งนั้น
                                            ขึ้นอยู่กับวิธีการจัดส่งที่คุณได้เลือกในขั้นตอนการสั่งซื้อ คือ
                                        </p>
                                        <ol class="text-tab">
                                            <li>การจัดส่งสินค้าทางไปรษณีย์แบบลงทะเบียน</li>
                                            <li>การจัดส่งสินค้าทางไปรษณียแบบ EMS</li>
                                            <li>การจัดส่งสินค้าผ่านบริษัทขนส่งเอกชน</li>
                                        </ol>
                                        <p class="text-indent">
                                            (วันเสาร์, วันอาทิตย์ และ วันหยุดนักขัตฤกษ์ ไม่นับเป็นวันทำการ)
                                            คุณสามารถตรวจสอบระยะเวลาการจัดส่งของสินค้ารายการนั้นๆได้
                                            ในหน้าประวัติการสั่งซื้อ
                                        </p>
                                        <img class="img-banner" src="{{asset('images/time-produce_01.png')}}">

                                        <h4 class="article-title">การติดตามออร์เดอร์</h4>
                                        <p class="text-indent">
                                            ลูกค้าสามารถตรวจสอบสถานะ ได้ทุกขั้นตอนตั้งแต่เริ่มผลิต
                                            ตลอดจนสินค้าจัดส่งถึงมือลูกค้า ได้ที่เมนูประวัติการสั่งซื้อ
                                            ในหน้าข้อมูลผู้ใช้เมื่อคุณเข้าสู่ระบบ
                                        </p>
                                        <p class="text-indent">
                                            ระบบของมูบาซ่าจะปรับปรุงข้อมูลเป็นรายวัน
                                            เพื่อที่จะให้บริการตรวจสอบสถานะคำสั่งซื้อที่ดีที่สุดแก่คุณ
                                            หากคุณไม่สามารติดตามออเดอร์ได้ กรุณาติดต่อเราที่ <a
                                                    href="{{ action('HelpController@getContact') }}">ติดต่อเรา</a>
                                            เราจะช่วยเหลือคุณทันที
                                        </p>

                                        <h4 class="article-title">ค่าบริการสำหรับการขนส่ง</h4>
                                        <p class="text-indent">

                                        </p>

                                        <h4 class="article-title">การจัดส่งไปต่างประเทศ</h4>
                                        <p class="text-indent">

                                        </p>

                                        <h4 class="article-title">กรณีไม่ได้รับสินค้า</h4>
                                        <p class="text-indent">
                                            ขั้นตอนการจัดส่งสินค้าจะใช้เวลา 1 - 5 วันทำการ (วันเสาร์, วันอาทิตย์ และ
                                            วันหยุดนักขัตฤกษ์ ไม่นับเป็นวันทำการ)
                                        </p>
                                        <p class="text-indent">
                                            หากคุณไม่ได้รับสินค้าภายในระยะเวลาการจัดส่งสินค้าตามที่ระบุไว้
                                            กรุณาติดต่อแผนกลูกค้าสัมพันธ์ได้ที่ 098 101 5050, 098 101 6060
                                            วันจันทร์-วันเสาร์ เวลา 09.00 - 19.00 ปิดทำการวันอาทิตย์
                                            และวันหยุดนักขัตฤกษ์ Email: {{ config('profile.email') }}

                                        </p>
                                    </div>
                                </div>
                                <div id="warranty" role="tabpanel" class="tab-pane fade ">
                                    <div class="tabpanel-body">
                                        <p class="text-indent">
                                            สิ่งสำคัญและเป็นนโยบายอย่างหนึ่งของมูบาซ่า คือ
                                            ความพึงพอใจของลูกค้าต่อสินค้าและบริการของเรา
                                            ลูกค้าทุกคุณที่สั่งซื้อสินค้าจาก
                                            {{ config('profile.sitename') }} จะได้รับสิทธิและการคุ้มครองจากเรา ดังนี้
                                        </p>
                                        <img class="img-banner" src="{{ asset('images/warranty_01.png') }}">
                                        <strong class="text-indent">
                                            สิทธิในการขอเปลี่ยนสินค้า
                                        </strong>

                                        <p class="text-indent">
                                            เปลี่ยนสินค้าได้ภายใน 10 วัน (นับจากวันที่จัดส่ง) ในกรณีดังต่อไปนี้
                                        </p>
                                        <ol class="text-tab">
                                            <li><b>ลายไม่สมบูรณ์ มีตำหนิ ขาดหาย</b></li>
                                            <li><b>สินค้ามีตำหนิ เสื้อขาด เย็บไม่ตรง</b></li>
                                            <li><b>ลายไม่ตรงกับที่สั่ง</b></li>
                                            <li><b>ได้รับเสื้อผิดไซส์</b></li>
                                        </ol>
                                        <strong class="text-indent">
                                            สิทธิในการขอคืนเงิน
                                        </strong>

                                        <p class="text-indent">
                                            เงื่อนไขในการขอคืนเงินเต็มจำนวน ได้แก่
                                        </p>
                                        <ol class="text-tab">
                                            <li>
                                                <b>ล่าช้าเกินกำหนด</b>&nbsp;ยังไม่ได้รับสินค้านานเกินกว่า 14 วัน
                                                นับตั้งแต่วันที่คุณชำระเงิน โดยดูวันที่จัดส่งในระบบ Tracking
                                                ของบริษัทจัดส่ง
                                            </li>
                                        </ol>
                                        <p class="text-indent">
                                            ไม่สามารถคืนเงินได้ตามกรณีต่อไปนี้
                                        </p>
                                        <ol class="text-tab">
                                            <li>
                                                <b>ไม่มีผู้รับสินค้า</b>
                                            </li>
                                        </ol>
                                        <p class="text-indent">
                                            ทั้งสองกรณีโปรดแจ้งความจำนงโดยติดต่อมาที่แผนกลูกค้าสัมพันธ์ได้ที่ 098 101
                                            5050, 098 101 6060
                                            วันจันทร์-วันเสาร์ เวลา 09.00 - 19.00 ปิดทำการวันอาทิตย์
                                            และวันหยุดนักขัตฤกษ์ Email: {{ config('profile.email') }}
                                        </p>
                                        <strong class="text-indent">
                                            ส่งสินค้าคืน
                                        </strong>

                                        <p class="text-indent">
                                            การส่งสินค้าคืนเพื่อเปลี่ยนสินค้า หรือขอรับเงินคืนจะต้องทำการภายใน 10
                                            วันหลังจากที่คุณได้รับสินค้า โดยส่งมาตามที่อยู่ 229/150 ซอย 5 ถ.อุดรดุษฎี
                                            ต.หมากแข้ง อ.เมือง จ.อุดรธานี 41000
                                            และโปรดแจ้งความจำนงโดยติดต่อมาที่แผนกลูกค้าสัมพันธ์ได้ที่ 098 101 5050, 098
                                            101 6060
                                            วันจันทร์-วันเสาร์ เวลา 09.00 - 19.00 ปิดทำการวันอาทิตย์
                                            และวันหยุดนักขัตฤกษ์ Email: {{ config('profile.email') }}
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
            </div>
        </div>
    </section>

    <section id="also-bought">
        <div class="container container-mobile">
            <div class="wrapper wrapper-white wrapper-content">
                <h4><strong>แนะนำสำหรับคุณ</strong></h4>

                <div id="carousel-also-bought" class="mycarousel-style1 carousel slide" data-ride="">
                    <!-- Wrapper for slides -->

                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <div class="row">
                                @foreach($latest_view_campaigns as $latest_view_campaign)
                                    <div class="col-sm-3">
                                        @include('layouts.include.product-box',['campaign'=> $latest_view_campaign])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{--<div class="item">--}}
                            {{--<div class="row">--}}
                                {{--@foreach($latest_view_campaigns as $latest_view_campaign)--}}
                                    {{--@include('layouts.include.product-box',['campaign'=> $latest_view_campaign])--}}
                                    {{--<div class="col-sm-3">--}}
                                        {{--<div class="product-box">--}}
                                            {{--<a href="">--}}
                                                {{--<div class="product-img">--}}
                                                    {{--<img src="{{ asset('images/mockup/img'. $ii = $i+9 .'.jpg') }}">--}}
                                                {{--</div>--}}
                                            {{--</a>--}}

                                            {{--<div class="product-detail">--}}
                                                {{--<div class="product-name text-center">--}}
                                                    {{--Campaign Name--}}
                                                {{--</div>--}}
                                                {{--<div class="product-description ">--}}
                                                    {{--<span class="price">--}}
                                                        {{--฿399--}}
                                                    {{--</span>--}}
                                                    {{--<span class="wish pull-right">--}}
                                                        {{----}}
                                                        {{--<a class="btn-wish-unlogin" data-toggle="modal"--}}
                                                           {{--href="#modal-login">--}}
                                                            {{--<i class="fa fa-heart-o"></i>&nbsp;--}}
                                                        {{--</a>--}}
                                                        {{----}}
                                                        {{--<a class="btn-add-cart" data-toggle="modal" href="#modal-cart">--}}
                                                            {{--<i class="fa fa-shopping-cart"></i>&nbsp;--}}
                                                        {{--</a>--}}
                                                    {{--</span>--}}
                                                {{--</div>--}}

                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--@endforeach--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#carousel-also-bought" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-also-bought" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="section-comment" class="section">
        <div class="container container-mobile">
            <div class="wrapper wrapper-white wrapper-content">
                <div class="box-header">
                    <div class="column">
                        <h4><strong>ความคิดเห็นของลูกค้า &nbsp;({{ $campaign->comments->count() }})</strong></h4>
                    </div>
                    <div class="column pull-right">
                        จัดเรียงตาม
                        <select name="q" id="sort-comment" class="">
                            <option value="1">ความเห็นยอดนิยม</option>
                            <option value="1">ความเห็นล่าสุด</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="comment-list">
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
                                        <strong class="media-heading"><a
                                                    href="{{ action('UserController@getIndex', $comment->user->getID()) }}">{{ $comment->user->getName() }}</a>
                                        </strong>

                                        <div class="comment-text">
                                            {{ $comment->message }}
                                        </div>
                                        <div class="comment-time">
                                            <span>{{ $comment->updated_at->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="group-like-comment">
                                            @if(\Auth::user()->check())
                                                <a href="javascript:void(0)" class="like-comment default"
                                                   data-comment-id="{{ $comment->id }}"
                                                   data-user-id="{{ \Auth::user()->user()->id }}">
                                                    <i class="fa {{ \Auth::user()->user()->isCommentLiked($comment->id) ? 'fa-thumbs-up' : 'fa-thumbs-o-up' }}"></i>
                                                </a>
                                            @endif
                                            &nbsp;<span class="like-count">{{ count($comment->likes) }}</span>&nbsp;
                                            ถูกใจ
                                            @if(\Auth::user()->check() && \Auth::user()->user()->id == $comment->user_id)
                                                <a href="javascript:void(0)" class="delete-comment"
                                                   data-comment-id="{{ $comment->id }}" data-user-id="{{ \Auth::user()->user()->id }}"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>ยังไม่มีความคิดเห็นใดๆ ในขณะนี้</p>
                        @endforelse
                    </div>
                    <hr>
                    @if(\Auth::user()->check())
                        <p class="text-right">
                            <button class="btn btn-warning" data-toggle="collapse" data-target="#writeComment">
                                แสดงความคิดเห็น
                            </button>
                        </p>

                        <div id="writeComment" class="collapse">
                            <strong>แสดงความคิดเห็นของคุณต่อสินค้าชิ้นนี้</strong>
                            <p>
                                <textarea name="message" id="message" class="form-control" cols="30" rows="5"
                                          placeholder="พิมพ์ความคิดเห็นของคุณ"></textarea>
                            </p>
                            <p class="">
                                <button id="btn-post-comment"
                                        data-user-id="{{ \Auth::user()->user()->id }}"
                                        class="btn btn-success" type="button"> ยืนยัน
                                </button>
                            </p>
                        </div>
                    @else
                        <p>
                            <a data-toggle="modal" href="#modal-login">เข้าสู่ระบบ</a>เพื่อแสดงความติดเห็น</p>
                    @endif
                </div>

            </div>
        </div>
    </section>


    <div id="modal-tshirt-size" class="modal fade modal-fullscreen" tabindex="-1" role="dialog"
         aria-labelledby="qrcodeline" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px solid #ddd;margin-bottom:10px;">
                    <strong class="modal-title" data-toggle="modal" data-targrt="#modal-tshirt-size">ตารางเปรียบเทียบขนาดเสื้อ</strong>
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