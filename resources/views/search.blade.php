@extends('layouts.full_width')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/color.css') }}">
    <style type="text/css">
        #search-more {
            display: none;
        }

        @media (max-width: 480px) {
            #search-more {
                display: block;
            }
        }
    </style>
@stop
@section('script')
    <script src="{{asset('js/jquery.lazyload.js')}}"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var src = "";
            // Start page for search result
            var current_page = 1;
            var last_page = 1;
            var total = 0;
            var bLazy = null;
            // Search criteria
            var search_criteria = {
                keyword: $("#search-input").val(),
                category_id: $("#category").val(),
                price_start: null,
                price_end: null,
                color_id: null,
                order_by: null,
                sort_by: null
            };
            loadSearchResult(current_page);

            $('#sort-select').change(function () {
                window.location = "/search/" + $(this).val();
            });
            $("#show-tool").click(function () {
                $("#search-tool").toggleClass('hide');
            });
            $('.product-thmb').hover(function () {
                if ($(this).find('img').attr('data-default') == 'front') {
                    $(this).find('img').attr('src', $(this).find('img').attr('data-back'));
                }
                else {
                    $(this).find('img').attr('src', $(this).find('img').attr('data-front'));
                }
            }, function () {
                if ($(this).find('img').attr('data-default') == 'front') {
                    $(this).find('img').attr('src', $(this).find('img').attr('data-front'));
                }
                else {
                    $(this).find('img').attr('src', $(this).find('img').attr('data-back'));
                }
            });

            /*effect filter*/
            var windowWidth = $(window).width();
            var windowHeight = $(document).height();
            $('.filter').css({
                'height': windowHeight + 'px',
            });

            /*$('.product-img img').load(function() {
             var productHeight = $('.product-img img').height();
             $('.product-img').css({
             'height' : (productHeight*65/100) + 'px'
             });
             });*/
            $('.filter').hide();
            $('#btn-filter').click(function () {
                $('.filter').show('slide', {direction: 'left'}, 500);
                setTimeout(function () {
                    $('.filter').addClass('in').height(windowHeight);
                }, 500);
                $('body').addClass('lock');
            });
            $('#close-filter').click(function () {
                $('.filter').hide('slide', {direction: 'left'}, 500);
                $('.filter').removeClass('in');
                $('body').removeClass('lock');
            });
            $('.filter').click(function () {
                $('.filter').hide('slide', {direction: 'left'}, 500);
                $('.filter').removeClass('in');
            }).children('.filter-wrapper').click(function (e) {
                return false;
                $('body').removeClass('lock');
            });

            function hideFilter(element) {
                element.hide('slide', {direction: 'left'}, 500);
                element.removeClass('in');
                $('body').removeClass('lock');
            }

            var lazyLoad = $("img.lazy").lazyload({
                threshold: 280,
                effect: "fadeIn",
                event: "sporty",
            });

            $(document).on("scrollstop", function () {
                if ($(window).scrollTop() >= (($(document).height() - $(window).height()))) {
                    current_page += 1;
                    if (current_page <= last_page) {
                        loadSearchResult(current_page);
                    }
                }
            });
            $(window).scroll(function () {
                if ($(window).scrollTop() == (($(document).height() - $(window).height()))) {
                    current_page += 1;
                    if (current_page <= last_page) {
                        loadSearchResult(current_page);
                    }
                }
            });
            function loadImage() {
                $("img.lazy").lazyload({
                    threshold: 280,
                    effect: "fadeIn",
                    event: "scroll",
                });
            }

            $("#search-more").click(function () {
                var element = $(this);

                current_page += 1;

                if (current_page <= last_page) {
                    loadSearchResult(current_page);
                }

                if (current_page >= last_page) {
                    element.attr("disabled", true);
                } else {
                    element.removeAttr("disabled");
                }
            });

            function loadSearchResult(next_page) {
                console.log(search_criteria);

                $.ajax({
                    type: "POST",
                    url: "/api/search",
                    data: {
                        search_criteria: search_criteria,
                        page: next_page
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            if (current_page == 1) {
                                $("#search-content").empty();
                            }
                            last_page = data.last_page;
                            total = data.total;
                            $.each(data.items, function (key, value) {
                                $("#search-content").append('<div class="col-md-3 col-sm-3 col-xs-6">' + value + '</div>');
                            });

                            loadImage();

                            setTimeout(function () {
                                console.log(lazyLoad);
                                $("img.lazy").trigger("sporty")
                            }, 3000);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            $("#advance-search-btn").click(function () {
                hideFilter($(".filter"));
                search_criteria.category_id = $("#category").val();
                search_criteria.price_start = $("#price-start").val();
                search_criteria.price_end = $("#price-end").val();

                var color_ids = [];

                $(".color-select.check").each(function() {
                    color_ids.push(parseInt($(this).data("color-id")));
                });
                search_criteria.color_id = color_ids;
                current_page = 1;

                loadSearchResult(current_page);
            });

            $(".order-by").click(function () {
                var element = $(this);

                search_criteria.order_by = element.data("order");
                search_criteria.sort_by = element.data("sort");
                current_page = 1;

                loadSearchResult(current_page);
            });


            $('.color-select').click(function () {
                $(this).toggleClass('check');
            });
        });

    </script>
@stop
@section('content')

    <div class="row">
        <div class="col-sm-4">
            <div class="">
                @if($keyword != '')
                    <h3>ผลการค้นหา "{{ $keyword }}"</h3>
                    @endif
                            <!--<p>(51)</p>-->
            </div>
            <br>
        </div>
        <div class="col-sm-8">

        </div>
    </div>
    <div class="row">

        <div class="col-md-6 col-sm-6 col-xs-6">
            <div class="">
                <button id="btn-filter" class="btn btn-default">
                    เครื่องมือค้นหา
                </button>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6  text-right">
            <div class="pull-right dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true">
                    เรียงตาม
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu " aria-labelledby="dropdownMenu1">
                    <li><a href="javascript:void(0)" class="order-by" data-order="hot">เรียงตาม ความนิยม</a></li>
                    <li><a href="javascript:void(0)" class="order-by" data-order="created_at" data-sort="dsc">เรียงตาม
                            ใหม่ล่าสุด</a></li>
                    <li><a href="javascript:void(0)" class="order-by" data-order="sell_price" data-sort="asc">เรียงตาม
                            ราคาต่ำ - สูง</a></li>
                    <li><a href="javascript:void(0)" class="order-by" data-order="sell_price" data-sort="dsc">เรียงตาม
                            ราคาสูง - ต่ำ</a></li>
                </ul>
            </div>
        </div>
    </div>
    <br>
    <div class="filter">
        <div class="filter-wrapper pull-left">
            <div class="filter-title">
                <button id="close-filter" type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4>ตัวกรองการค้นหา</h4>
            </div>
            <div class="filter-body">
                <div class="list-group">
                    <p class="list-group-item">
                        <label>หมวดหมู่</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">ทั้งหมด</option>
                            @foreach(\App\CampaignCategory::active()->get() as $category)
                                <option value="{{ $category->id }}" {{ isset($selected_category) && $selected_category->id == $category->id ? 'selected' : '' }}>{{ $category->detail }}</option>
                            @endforeach
                        </select>
                    </p>
                    <p class="list-group-item">
                        <label>ราคา</label>
                       <span class="input-price pull-right">
                            <input type="number" id="price-start" class="form-control" value="0">
                            -
                            <input type="number" id="price-end" class="form-control" value="1000">
                       </span>
                    </p>
                    <p id="list-group-color" class="list-group-item">
                        <label>สี</label>
                        <span class="color-list">
                            @foreach(\App\ProductColor::getAvailableColor() as $color)
                                <a href="javascript:void(0)" class="color-select" style="background:{{ $color->color }}"
                                   title="{{ $color->color_name }}" data-color-id="{{ $color->id }}">
                                    <i class="fa fa-check"></i>
                                </a>
                            @endforeach
                        </span>
                    </p>
                    <p class="list-group-item text-center">
                        <button class="btn btn-success btn-block" id="advance-search-btn">ตกลง</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="search-content">
    </div>
    
@stop
