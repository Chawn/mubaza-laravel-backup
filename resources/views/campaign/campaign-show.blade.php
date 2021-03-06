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
    <script src="{{asset('js/jquery.lazyload.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.campaigns-slider').bxSlider({
                slideWidth: 140,
                minSlides: 1,
                maxSlides: 3,
                slideMargin: 10
            });

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
                var product_id = $("#tshirt-type").val();
                var selected_product = $(campaign_products).filter(function () {
                    return this.product_id == product_id;
                })[0];
                window.location.href = campaign.url + "_" + selected_product.url_slug + ".html";
//                selected_item.product_id = $(this).val();
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
                        if(tshirt_type.data("selected-type") == v.product_id)
                        {
                            tshirt_type.append('<option value="' + v.product_id + '" selected>' + v.name + ' - ฿' + v.sell_price + '</option>');
                        } else {
                            tshirt_type.append('<option value="' + v.product_id + '">' + v.name + ' - ฿' + v.sell_price + '</option>');
                        }
                    }
                });
                changeProductSizeChartImage();
                loadColor(tshirt_type.val());
//                tshirt_type.val(primary_id);
//                tshirt_type.trigger("change");
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
                var color_checked = false;
                $.each(product_colors, function (k, v) {
                    if (!color_checked)
                    {
                        if(color_panel.data("selected-color") == 0 && v.is_primary) {
                            color_checked = true;
                            selected = "color";
                        } else if(color_panel.data("selected-color") == v.product_color_id) {
                            color_checked = true;
                            selected = "color"
                        }
                    } else {
                        selected = "";
                    }
                    color_panel.append('<li class="color-button"><a href="' + campaign.url + '_' + v.url_slug + "-" + v.color_name + '.html' +
                            '"class="color-select ' + selected + '" ' +
                            'data-campaign-product-id="' + v.campaign_product_id + '" ' +
                            'data-color-id="' + v.product_color_id + '" ' +
                            'data-image-front="' + v.image_front + '" ' +
                            'data-image-back="' + v.image_back + '" ' +
                            'data-sell-price="' + v.sell_price + '" ' +
                            'style="background-color:' + v.color + '"><i class="fa fa-check"></i></a></li>');
                });

                baseEvent();
                $(".color:first-child").trigger("click");
            }

            function changeProductSizeChartImage() {
                var selected_product_id = selected_item.product_id;

                var selected_product = $(campaign_products).filter(function () {
                    return this.product_id == selected_product_id;
                })[0];
                if(selected_product != undefined) {
                    var size_chart_image = $("#size-chart-image");
                    size_chart_image.attr("src", selected_product.size_chart);
                }
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
                    $("#image-front").attr("data-original", "{{ url('/') }}/campaign/file/" + campaign.id + "/" + image_front);
                    $("#image-front").attr("src", "{{ url('/') }}/campaign/file/" + campaign.id + "/" + image_front);
                }
                if (image_back != "") {
                    $("#image-back").attr("data-original", "{{ url('/') }}/campaign/file/" + campaign.id + "/" + image_back);
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
                title: 'คุณสมบัติ',
                content: '<ul><li>ใส่ได้ทั้งชายและหญิง (Unisex T-Shirt)</li><li>เนื้อผ้า Cotton 100%</li><li>สัมผัสอ่อนโยนต่อผิว</li><li>ระบายอากาศได้ดี</li></ul>',
                multi: true,
                closeable: false,
                style: '',
                delay: 300,
                padding: true,
                backdrop: false
            });

            $(".like-comment").click(function () {
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
                        if (!data.success) {
                        } else {
                            var parent = element.closest("div.group-like-comment");
                            parent.find("span.like-count").html(data.count);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            $(".delete-comment").click(function () {
                var result = confirm("คุณต้องการลบความคิดเห็นนี้?");
                if (result) {
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
                        } else {
                            element.closest("div.media").remove();
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

        });
        $(function () {
            $("img.lazy").lazyload({
                threshold: 280,
                effect: "fadeIn",
                event: "sporty",
            });
            $("#sort-comment").change(function() {
                window.location = $(this).val();
            });

        });
        $(window).bind("load", function () {
            var timeout = setTimeout(function () {
                $("img.lazy").trigger("sporty")
            }, 2000);
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

        .comment-time {
            color: #999;
        }

        .like-comment:hover,.like-comment:focus{
            text-decoration: none;
        }

        .column {
            padding: 8px;
        }

        #campaign-select-show {
            min-height: 488px;
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

            #campaign-select-show {
                min-height: 300px;
            }
        }

        @media (max-width: 767px) {
            .column.pull-right {
                float: none !important;
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
                    @if ($campaign->status->name!='check')
                        <div class="alert alert-primary alert-tool space-top-lg-3">
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
                    @else
                        <div class="alert alert-warning">
                                <p class="text-orange text-center font-big">
                                    <i class="fa fa-clock-o"></i>
                                    {{ $campaign->status->detail }}
                                </p>
                        </div>
                        
                    @endif
                    
                </div>
            </section>
        @endif
    @endif
    <section id="campaign-select" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-sm-6 nonpading-mobile">
                    <div class="wrapper wrapper-white wrapper-content">
                        <div id="campaign-select-show">
                            <div class="flip-container">
                                <div class="flipper">
                                    <div class="front select-img ">
                                        <img class="zoomTarget tshirt lazy" id="image-front"
                                             src="{{'images/t-holder.png'}}"
                                             data-original="{{ action('CampaignController@getFile', [$campaign->id, $campaign->frontCover($selected_product->id)]) }}">
                                    </div>
                                    <div class="back select-img">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3>
                            <strong>{{ $campaign->title }}</strong>
                        </h3>
                        <p class="">รหัสสินค้า: <strong>{{ $campaign->id }}</strong></p>
                        <div class="campaign_description">
                            {!! $campaign->description !!}
                        </div>
                        <div class="tag">
                            @foreach($campaign->tags as $tag)
                                <span><a href="{{ url('/search?q=' . $tag->name) }}"></a></span>
                            @endforeach
                        </div>
                        <hr>
                        <p class="text-grey">สงวนลิขสิทธิ์งานออกแบบ &copy; {{ $campaign->user->getName() }}</p>

                    </div>
                </div>
                <div class="col-md-5 col-sm-6 nonpading-mobile bg-grey">
                    <div class="select-product-wrapper wrapper wrapper-white wrapper-content">
                        <div class="select-product">
                            <div class="form-group space-1">
                                <label for="tshirt-type">แบบเสื้อ:</label>
                                <div class="clearfix"></div>
                                <select name="tshirt-type" id="tshirt-type" class="form-control column" data-selected-type="{{ $selected_product->color->product_id }}">
                                </select>
                                {{-- <a href="#" data-animation="pop" data-placement="vertical" class="show-pop column"
                                   data-content=""><i class="fa fa-question-circle"></i>
                               </a> --}}
                            </div>
                            <div class="form-group space-1">
                                <label class=" ">สี:</label>
                                <div class="clearfix"></div>
                                <div id="">
                                    <ul id="color-panel" class="list-unstyled list-inline" style="margin-left:0;" data-selected-color="{{ $selected_product->product_color_id }}">

                                    </ul>
                                </div>
                            </div>
                            <div class="form-group space-1">
                                <label class=" ">ไซส์:</label>
                                <div class="clearfix"></div>
                                
                                <div class="box-size">
                                    <div id="size-panel"></div>
                                    <p></p>
                                    <a class="" id="size-chart" style="padding:5px 0;" href="javascript:void(0)"
                                       data-toggle="modal" data-target="#modal-tshirt-size">
                                        ตารางเปรียบเทียบขนาด
                                    </a>
                                </div>
                                
                            </div>
                            @if($campaign->end != null)
                                <div class="form-group space-1">
                                    <label class=" ">เหลือเวลา</label>
                                    <div class="col-sm-9">
                                        <div id="box-timecount" data-end="{{ $campaign->end->format('Y/m/d H:i:s') }}">
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group space-1">
                                {{-- <strong class="" id="price"></strong> THB--}}
                                <button class="btn btn-success btn-block btn-xl {{ ($campaign->status->name=='check') ? 'disabled' : '' }}" id="add-to-cart">
                                    <i class="fa fa-shopping-cart"></i> หยิบใส่รถเข็น
                                </button>
                            </div>
                            <div class="form-group space-1">
                                    @if(\Auth::user()->check())
                                        <a
                                                class="add-to-wish-list wish text-grey"
                                                data-user-id="{{ \Auth::user()->user()->id }}"
                                                data-campaign-id="{{ $campaign->id }}"
                                                href="javascript:void(0)">
                                            <i class="fa {{ \Auth::user()->user()->isAddedToWishList($campaign->id) ? 'fa-heart': 'fa-heart-o' }}"></i>
                                            <span id="wishlist-text">{{ \Auth::user()->user()->isAddedToWishList($campaign->id) ? 'บันทึกในรายการโปรดแล้ว' : 'เพิ่มในรายการโปรด' }}</span>
                                        </a>
                                    @else
                                        <a id="unwishlish" class="wish text-grey"
                                           data-toggle="modal" href="#modal-login">
                                            <i class="fa fa-heart-o"></i> <span
                                                    id="wishlist-text">เพิ่มในรายการโปรด</span>
                                        </a>
                                    @endif
                            </div>
                        </div>
                        <hr>
                        <div class="">
                            <div class="form-group space-1">
                                <label class="">
                                    แชร์:
                                </label>
                                <div class="social-share-tool">
                                    <ul class="list-inline list-unstyled">
                                        <li>
                                            <a href="javascript:void(0)"
                                               onclick="popUp=window.open('http://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false"
                                               class="i-share-facebook"></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)"
                                               onclick="popUp=window.open('https://plus.google.com/share?url={{ urlencode(Request::url()) }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false"
                                               class="i-share-google"></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)"
                                               onclick="popUp=window.open('https://twitter.com/intent/tweet?original_referer={{ urlencode(Request::url()) }}&text={{ $campaign->title }}&tw_p=tweetbutton&url={{ Request::url() }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false"
                                               class="i-share-twitter"></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)"
                                               onclick="popUp=window.open('http://www.pinterest.com/pin/create/button/?url={{ Request::url() }}&media={{ action('CampaignController@getFile', [$campaign->id, $campaign->frontCover('image_front_medium')]) }}&description={{ $campaign->title }})','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false"
                                               class="i-share-pinterest"></a>
                                        </li>
                                    </ul>
                                    <!--<p><small>เข้าสู่ระบบแล้วแชร์จะได้รับแต้ม และเปลี่ยนเป็นคูปองส่วนลดได้</small></p>-->
                                </div>
                            </div>

                            <hr>

                            <div class="row space-1">
                                <div class="col-sm-12">
                                    
                                    <h4 class="warranty link-reset">
                                        <i class="fa fa-thumbs-o-up"></i> รับประกันความพึงพอใจ 100%
                                    </h4>
                                
                                    <div class="hotline">
                                        <i class="fa fa-phone"></i> สั่งซื้อทางโทรศัพท์
                                        โทร. {{ config('profile.phone-primary') }}
                                        <br>
                                        <small>วันจันทร์ - ศุกร์ เวลา 8:30 - 17:30 น.</small>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="campaign-designer text-center">
                                <a class="text-center"
                                   href="{{ action('UserController@getCreatorShow',$campaign->user->getID()) }}">
                                            <span class="profile-circle" style="width:60px;height:60px;">
                                                <span class="profile-image"
                                                      style="background-image:url('{{ $campaign->user->avatar }}')"></span>
                                            </span>
                                    <p class="text-grey">
                                        {{ $campaign->user->getName() }}
                                    </p>
                                </a>
                                @if(\Auth::user()->check())
                                    @if(\Auth::user()->user()->id != $campaign->user->id)
                                        @if(\Auth::user()->user()->isSubscribed($campaign->user->id))
                                            <button class="follow-btn btn btn-success"
                                                    data-user-id="{{ $campaign->user->id }}"
                                                    data-subscriber-id="{{ \Auth::user()->user()->id }}">
                                                <i class="fa fa-check-circle"></i>
                                                Following
                                            </button>
                                        @else
                                            <button class="follow-btn btn btn-default"
                                                    data-user-id="{{ $campaign->user->id }}"
                                                    data-subscriber-id="{{ \Auth::user()->user()->id }}">
                                                <i class="fa fa-plus-circle"></i>
                                                Follow
                                            </button>
                                        @endif
                                    @endif
                                @else
                                    <button class="follow-btn btn btn-default" data-toggle="modal" href="#modal-login">
                                        <i class="fa fa-plus-circle"></i> Follow
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @if(count($related_campaigns) >=6)
        @include('layouts.include.campaigns-slider',['campaigns'=> $related_campaigns, 'title' => 'สินค้าอื่นของครีเอเตอร์นี้'])
    @elseif(count($latest_view_campaigns)>=6)
        @include('layouts.include.campaigns-slider',['campaigns'=> $latest_view_campaigns,'title' => 'สินค้าที่เพิ่งเข้าชมล่าสุด'])
    @endif
    
    <section id="section-comment" class="section">
        <div class="container container-mobile">
            <div class="wrapper wrapper-white wrapper-content">
                <div class="box-header">
                    <div class="column">
                        <h4><strong>ความคิดเห็นของลูกค้า &nbsp;({{ $campaign->comments->count() }})</strong></h4>
                    </div>
                    <div class="column pull-right">
                        จัดเรียงตาม
                        <select name="comment_order" id="sort-comment" class="">
                            <option value="{{ \Request::url() }}?comment_order=likes" {{ $comment_order == 'likes' ? 'selected' : '' }}>ความเห็นยอดนิยม</option>
                            <option value="{{ \Request::url() }}?comment_order=newer" {{ $comment_order == 'newer' ? 'selected' : '' }}>ความเห็นล่าสุด</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="comment-list">
                    <div class="group-comment">
                        @forelse($comments as $comment)
                            <div class="media">
                                <div class="media-left">
                                    <a href="{{ action('UserController@getIndex', $comment->user_id) }}">
                                        <span class="profile-circle" style="width:45px;height:45px;">
                                            <span class="profile-image"
                                                  style="background-image:url('{{ $comment->avatar }}');"> </span>
                                        </span>
                                    </a>
                                </div>
                                <div class="media-body">
                                    <div class="col-md-10">
                                        <strong class="media-heading"><a
                                                    href="{{ action('UserController@getIndex', $comment->user_id) }}">{{ \App\User::getFullName($comment->user_id) }}</a>
                                        </strong>

                                        <div class="comment-text">
                                            {{ $comment->message }}
                                        </div>
                                        <div class="comment-time">
                                            <span>{{ $comment->updated_at }}</span>
                                        </div>
                                        <div class="group-like-comment">
                                            @if(\Auth::user()->check())
                                                <a href="javascript:void(0)" class="like-comment default"
                                                   data-comment-id="{{ $comment->id }}"
                                                   data-user-id="{{ \Auth::user()->user()->id }}">
                                                    <i class="fa {{ \Auth::user()->user()->isCommentLiked($comment->id) ? 'fa-thumbs-up' : 'fa-thumbs-o-up' }}"></i>
                                                </a>
                                            @endif
                                            &nbsp;<span class="like-count">{{ $comment->like_count }}</span>&nbsp;
                                            ถูกใจ
                                            @if(\Auth::user()->check() && \Auth::user()->user()->id == $comment->user_id)                                               <a href="javascript:void(0)" class="delete-comment"
                                                   data-comment-id="{{ $comment->id }}"
                                                   data-user-id="{{ \Auth::user()->user()->id }}"><i
                                                            class="fa fa-trash"></i></a>
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
                            <a data-toggle="modal" href="#modal-login">เข้าสู่ระบบ</a>เพื่อแสดงความคิดเห็น</p>
                    @endif
                </div>

            </div>
        </div>
    </section>


    <div id="modal-tshirt-size" class="modal fade modal-fullscreen" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px	solid #ddd;margin-bottom:10px;">
                    <strong class="modal-title" data-toggle="modal" data-targrt="#modal-tshirt-size">ตารางเปรียบเทียบขนาด</strong>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-12 col-sm-12 mobile-hidden">
                        <img width="100%" src="" id="size-chart-image">
                    </div>
                        </div>
                </div>
                <div class="modal-footer" style="background: #fff;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
@stop