@extends('manager.layouts.master')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('script')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"></script>
    <script src="{{ asset('ckeditor-custom/ckeditor.js') }}"></script>
    <script src="{{ asset('js/selectize/selectize.min.js') }}"></script>
    <script src="{{ asset('datetimepicker-master/jquery.datetimepicker.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/store.js') }}"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery('#endDate').datetimepicker({
                format: 'd/m/Y H:i',
                inline: false,
                lang: 'th'
            });
            $('#tags').selectize({
                delimiter: ',',
                maxItems: 5,
                persist: false,
                create: function (input) {
                    return {
                        value: input,
                        text: input
                    }
                }
            });
            $(".slider-range").each(function () {
                var element = $(this);
                var parent = element.closest(".slider-group");
                var price = parent.find(".price");
                element.slider({
                    value: parseInt(price.data("sell-price")),
                    min: parseInt(price.data("min")),
                    max: parseInt(price.data("max")),
                    step: 1,
                    slide: function (event, ui) {
                        price.val(ui.value);
                    }
                });
            });

            $(".price").on("change", function() {
                var element = $(this);
                var min = parseInt(element.data("min"));
                var max = parseInt(element.data("max"));
                if(element.val() == "" || element.val() < min) {
                    element.val(min);
                } else if(element.val() > max) {
                    element.val(max);
                }
                var slider = $(element.data("target"));
                slider.slider("value", element.val());
            });
//            $(".slider").each(function () {
//                // $this is a reference to .slider in current iteration of each
////                var $this = $(this);
//                // find any .price element WITHIN scope of $this
//                var price = $(this).find('.price');
//                // find any .slider-range element WITHIN scope of $(this)
//                var slider_range = $(this).find('.slider-range');
//                $(this).find(".min-text").html("฿" + price.data("min"));
//                $(this).find(".max-text").html("฿" + price.data("max"));
//                // on slide
//                console.log(slider_range);
////                $(this).find(".slider-range").slider({
////                    value: price.val(),
////                    min: price.data('min'),
////                    max: price.data('max'),
////                    step: 1,
////                    slide: function (event, ui) {
////                        price.val(ui.value);
////                    }
////                });
////                // change price when slide
////                price.val(slider_range.slider("value"));
////
////                price.change(function () {
////                    // slide when change price
////                    slider_range.slider("value", price.val());
////                });
//            });

            $(".product-thumbnail").click(function () {
                var thmb = $(this);
                setPrimary(thmb.data("campaign-product-id"));
            });
            $(".set-primary-btn").click(function() {
                var element = $(this);

                setPrimary(element.data("campaign-product-id"));
            });

            function setPrimary(campaign_product_id) {
                $.ajax({
                    type: "POST",
                    url: "/campaign/set-primary/" + campaign_product_id,
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }
            $("#save-price").click(function () {
                saveSellPrice($(this).data("campaign-id"));
            });

            function saveSellPrice(campaign_id) {
                var prices = [];

                $(".price").each(function () {
                    var price = {
                        product_id: $(this).data("product-id"),
                        sell_price: $(this).val()
                    };

                    prices.push(price);
                });

                $.ajax({
                    type: "POST",
                    url: "/manager/update-sell-price/" + campaign_id,
                    data: {
                        data: prices
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            $("input[name=limit_time]").change(function () {
                if ($('input[name=limit_time]:checked').val() == 1) {
                    $("#select-end-date").removeClass("hidden");
                } else {
                    $("#select-end-date").addClass("hidden");
                }
            });

            $("#endDate").change(function () {
                var end_date = $("#endDate");
                var current_date = moment();
                var choose_date = moment(end_date.val(), 'DD/MM/YYYY');
                var diff_day = parseInt(choose_date.diff(current_date, 'd'));
                if (current_date.isAfter(choose_date) || current_date.isSame(choose_date)) {
                    alert('ไม่สามารถเลือกเป็นวันปัจจุบันได้');
                    $('#close-date').val(current_date.add(7, 'd').format('DD/MM/YYYY'));
                }
                if (diff_day > 30) {
                    alert('ไม่สามารถกำหนดวันที่สิ้นสุดเกิน 30 วันได้');
                    $('#close-date').val(current_date.add(7, 'd').format('DD/MM/YYYY'));
                }
            });
            $("#save-btn").click(function () {
                if ($("#title").val() == "") {
                    alert("คุณจำเป็นต้องมีหัวข้อ");
                    $("#title").focus();
                    return false;
                }

                if ($("#category").val() == 0) {
                    alert("คุณจำเป็นต้องเลือกหมวดหมู่ของสินค้า");
                    $("#category").focus();
                    return false;
                }

                if (CKEDITOR.instances.description.getData() == "") {
                    alert("คุณจำเป็นต้องมีรายละเอียดสินค้า");
                    CKEDITOR.instances.description.focus();
                    return false;
                }

                if ($("#tags").val() == "") {
                    alert("คุณจำเป็นต้องมีแทกสำหรับสินค้า");
                    $("#tags").focus();
                    return false;
                }

                if ($('input[name=limit_time]:checked').val() == 1) {
                    if ($("#endDate").val() == "") {
                        alert('คุณจำเป็นต้องกำหนดวันสิ้นสุด');
                        $("#endDate").focus();
                        return false;
                    }
                }

                saveCampaign();
            });

            function saveCampaign() {
                var sell_price = [];
                var end = null;

                if ($('input[name=limit_time]:checked').val() == 1) {
                    end = $("#endDate").val();
                }

                var prices = [];

                $(".price").each(function () {
                    var price = {
                        product_id: $(this).data("product-id"),
                        sell_price: $(this).val()
                    };

                    prices.push(price);
                });
                $.ajax({
                    type: "POST",
                    url: "/campaign/update-campaign/" + $("#save-btn").data("campaign-id"),
                    data: {
                        title: $("#title").val(),
                        campaign_category_id: $("#category").val(),
                        description: CKEDITOR.instances.description.getData(),
                        tags: $("#tags").val(),
                        end: end,
                        prices: prices
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
//                            console.log(data);
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            $("[name='status_switch']").bootstrapSwitch();

            $('input[name="status_switch"]').on('switchChange.bootstrapSwitch', function (event, state) {
                var element = $(this);
                if (state) {
                    openCampaign(element.data("campaign-id"));
                } else {
                    closeCampaign(element.data("campaign-id"));
                }
            });
            function openCampaign(campaign_id) {
                $.ajax({
                    type: "GET",
                    url: "/campaign/open/" + campaign_id,
                    dataType: "json",
                    success: function (data) {
                        window.location.reload();
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            function closeCampaign(campaign_id) {
                $.ajax({
                    type: "GET",
                    url: "/campaign/close/" + campaign_id,
                    dataType: "json",
                    success: function (data) {
                        window.location.reload();
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            $("#open-campaign").click(function () {
                var element = $(this);
                openCampaign(element.data("campaign-id"));
            });
            $("#close-campaign").click(function () {
                var element = $(this);
                closeCampaign(element.data("campaign-id"));
            });
        });
    </script>
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('datetimepicker-master/jquery.datetimepicker.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/selectize/selectize.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/selectize/selectize.bootstrap3.css') }}"/>
    <style type="text/css" media="screen">
        .product-img img {
            max-width: 70px;
            margin: 0 auto;
        }

        .image-big img {

        }

        .product-img img.active {
            border: solid 1px rgb(85, 189, 83);
        }
    </style>
@stop
@section('content')
    <div class="box-create">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <h2>{{ $campaign->title }}</h2>

                </div>
                <div class="col-sm-6">
                    <p class="text-right">
                        <!--
                        <button class="btn btn-default">
                            ขายแล้ว <span class="badge">-</span>
                        </button>
                        <button class="btn btn-default">
                            เข้าชม <span class="badge badge-info">-</span>
                        </button>
                        -->
                        <a href="{{ url('/') .'/'. $campaign->url .'.html' }}" class="btn btn-default">
                            <i class="fa fa-search"></i> หน้าแสดงสินค้า
                        </a>
                    </p>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    Product id: {{ $campaign->id }}
                </div>
                <div class="col-xs-6">
                    <p class="text-right">
                        Status:
                            <span>
                                <input type="checkbox" name="status_switch" state="true"
                                       data-size="mini" data-on-color="success"
                                       data-on-text="ON" data-off-text="OFF" data-campaign-id="{{ $campaign->id }}"
                                        {{ $campaign->status->name=='active' ? 'checked' : '' }}>
                            </span>
                    </p>
                </div>
            </div>
            <div class="row">

                <!-- Image -->

                <!-- End Image-->

                <!-- Product-->
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            สินค้าที่เปิดขาย


                        </div>

                        <div class="panel-body row">
                            <div class="col-sm-4">
                                <div class="image-big">
                                    <img class=" img-responsive"
                                         src="{{ action('CampaignController@getFile', [$campaign->id, $campaign->frontCover()]) }}">

                                    {{--<p class="text-center">ด้านหน้า</p>--}}
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <table class="table table-hover dataTable ">
                                    <tr>
                                        <th>
                                            รูปตัวอย่างสินค้า
                                        </th>
                                        <th>
                                            ชื่อสินค้า
                                        </th>
                                        <th width="38%">
                                            เครื่องมือ
                                        </th>
                                    </tr>
                                    @foreach($campaign->products as $product)
                                        <tr class="">
                                            <td>
                                                <a href="javascript:void(0)">
                                                    <div class="product-img">
                                                        <img class="thumbnail img-responsive product-thumbnail {{ $product->is_primary ? 'active' : '' }}"
                                                             data-campaign-product-id="{{ $product->id }}"
                                                             data-remove-btn="{{ '#remove-' . $product->id }}"
                                                             src="{{ action('CampaignController@getFile', [$campaign->id, $product->image_front_small]) }}">
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <p>{{ $product->color->product->name }}</p>

                                                <p>{{ $product->color->color_name }}</p>
                                            </td>
                                            <td>
                                                @if($product->is_primary)
                                                    <button class="btn btn-default-shadow btn-sm" disabled><i class="fa fa-check text-success"></i> แสดงหน้าสินค้าแล้ว</button>
                                                @else
                                                    <button class="btn btn-default-shadow btn-sm set-primary-btn"
                                                            data-campaign-product-id="{{ $product->id }}"><i class="fa fa-check"></i>&nbsp;ตั้งให้แสดงหน้าสินค้า</button>
                                                @endif
                                                <a href="{{ action('CampaignController@getRemoveProduct', $product->id) }}"
                                                   class="btn btn-sm btn-default-shadow"  {{ $product->is_primary ? 'disabled' : '' }}
                                                   id="{{ 'remove-' . $product->id }}">
                                                    <i class="fa fa-close"></i> ลบ
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                <a href="{{ action('AssociateController@getAddProduct', $campaign->id) }}"
                                   class="btn btn-success pull-right">
                                    <i class="fa fa-plus-circle"></i> เพิ่มแบบอื่น
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- End Product-->
            </div>

            <div class="row">
                <!-- Detail -->
                <div class="col-sm-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            รายละเอียด
                        </div>

                        <div class="panel-body">
                            <label class="title" for="title">หัวข้อ</label>
                            <input id="title" name="title" class="form-control" value="{{ $campaign->title }}" required>

                            <p>
                                <small>สรุปหัวข้อของคุณใน 40 ตัวอักษรหรือน้อยกว่า</small>
                            </p>

                            <br>
                            <label class="title" for="category">หมวดหมู่</label>
                            <select id="category" name="category" class="form-control" required>
                                <option value="0">เลือกหมวดหมู่สินค้า</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id === $campaign->campaign_category_id ? 'selected' : ''  }}>{{ $category->detail }}</option>
                                @endforeach
                            </select>
                            <br>
                            <label class="title" for="description">รายละเอียด</label><br>
                            <textarea name="description" id="description" class="form-control description" rows="3"
                                      required>{{ $campaign->description }}</textarea>

                            <p>
                                <small>บอกเรื่องราว ที่มา หรือความหมาย เพื่อเพิ่มความน่าสนใจให้กับสินค้า</small>
                            </p>
                            <script>
                                CKEDITOR.replace('description');
                            </script>
                            <br>
                            <label class="title" for="tags">แท็ก</label>
                            <input type="text" class="form-control" id="tags" name="tags"
                                   value="{{ $campaign->allTags() }}" required>

                            <p>
                                <small>สามารถใส่ได้สูงสุด 5 แท็ก ขั้นแต่ละคำด้วย "," (คอมม่า) เช่น แมว, แมวสีขาว, Cat,
                                    White Cat
                                    <br><strong class="">ใช้คำที่เกี่ยวข้องกับลาย</strong>
                                    จะช่วยให้ลูกค้าค้นหาเจอได้ง่ายขึ้นบนเว็บของเรา และจากเว็บค้นหาอื่นๆ
                                </small>
                            </p>


                        </div>
                    </div>
                   {{--  <div class="panel panel-default" style="min-height:240px;">
                        <div class="panel-heading">
                            กำหนดวันสิ้นสุด
                        </div>
                        <div class="panel-body">
                            <div class="checkbox">
                                <p>
                                    <label>
                                        <input type="radio" name="limit_time"
                                               value="0" {{ $campaign->end == null ? 'checked' : '' }}> ปิดการใช้งาน
                                        (อัตโนมัติ)
                                    </label>
                                </p>

                                <p>
                                    <label>
                                        <input type="radio" name="limit_time"
                                               value="1" {{ $campaign->end != null ? 'checked' : '' }}>
                                        เปิดใช้งานวันสิ้นสุด <span class="text-danger">*</span>
                                    </label>
                                </p>
                            </div>
                            <div class="form-group {{ $campaign->end == null ? 'hidden' : '' }}" id="select-end-date">
                                <label>เลือกวันสิ้นสุด</label>
                                <input class="form-control" id="endDate" type="text" name="endDate"
                                       value="{{ $campaign->end != null ? $campaign->end->format('d/m/Y H:i') : '' }}">
                            </div>

                            <small><strong class="text-danger">* การกำหนดวันสิ้นสุด</strong> หมายถึง
                                สินค้าของคุณจะเปิดขายเพียงช่วงระยะเวลาหนึ่ง เมื่อถึงระยะเวลาสิ้นสุดที่คุณกำหนด
                                การขายจะถูกปิดลงโดยอัตโนมัติ
                            </small>
                        </div>
                    </div> --}}
                </div>
                <!-- End Detail -->

                <!-- Price -->
                <div class="col-sm-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            ตั้งราคาสินค้า
                        </div>

                        <div class="panel-body">
                            @foreach($campaign->getGroupProduct() as $product)
                                <div class="row slider">
                                    <div class="col-sm-5">
                                        <p class="text-center product-img">
                                            <img class="thumbnail img-responsive"
                                                 src="{{ action('CampaignController@getFile', [$campaign->id, $product->image_front_small]) }}">
                                            <strong>{{ \App\Product::find($product->product_id)->name }}</strong>
                                        </p>
                                    </div>
                                    <div class="col-sm-7 slider-group">
                                        <div class="input-group">
                                            <input type="number" class="price form-control"
                                                   min="{{ $campaign->both_print ? $product->two_side_price : $product->one_side_price }}"
                                                   max="{{ $product->max_price }}"
                                                   data-product-id="{{ $product->id }}"
                                                   data-sell-price="{{ $product->sell_price }}"
                                                   data-min="{{ $campaign->both_print ? $product->two_side_price : $product->one_side_price }}"
                                                   data-max="{{ $product->max_price }}"
                                                   value="{{ $product->sell_price }}"
                                                    data-target="#slider-{{ $product->id }}">
                                            <span class="input-group-addon">บาท</span>
                                        </div>
                                        <div class="row ">
                                            <div class="col-sm-6">
                                                <strong class="text-warning min-text" style="color:#f6931f;">
                                                    ฿{{ $campaign->both_print ? $product->two_side_price : $product->one_side_price }}
                                                </strong>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong class="text-warning pull-right max-text" style="color:#f6931f;">
                                                    ฿{{ $product->max_price }}
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="slider-range" id="slider-{{ $product->id }}"></div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                            {{--<button class="btn btn-success btn-lg btn-block" id="save-price"--}}
                            {{--data-campaign-id="{{ $campaign->id }}">บันทึกราคา--}}
                            {{--</button>--}}
                        </div>
                    </div>
                    <!-- End Panel -->
                </div>
                <!-- End Price -->
            </div>

            <div class="row">
                @if($campaign->status->name == 'close')
                    <div class="col-sm-6">
                        <a href="javascript:void(0)"
                           class="btn btn-warning btn-lg btn-block" id="open-campaign" data-campaign-id="{{ $campaign->id }}">เปิดการขาย</a>
                    </div>
                @endif
                @if($campaign->status->name == 'active')
                    <div class="col-sm-6">
                        <a href="javascript:void(0)"
                           class="btn btn-warning btn-lg btn-block" id="close-campaign" data-campaign-id="{{ $campaign->id }}">ปิดการขายชั่วคราว
                        </a>
                    </div>
                @endif
                <div class="col-sm-6">
                    <button class="btn btn-success btn-lg btn-block" id="save-btn"
                            data-campaign-id="{{ $campaign->id }}">บันทึกการเปลี่ยนแปลง
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop