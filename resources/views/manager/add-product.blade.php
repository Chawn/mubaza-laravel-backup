@extends('manager.layouts.master')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('script')
    <script src="{{ asset('js/store.js') }}"></script>
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var campaign = null;

            var new_product = {
                campaign_id: $("#add-product").data("campaign-id"),
                product_color_id: null,
                front_shirt: 0,
                image_front: {
                    full_path: $(".shirt-front-preview").data("default"),
                    path: '',
                    file_name: {
                        large: '',
                        thumbnail: ''
                    }
                },
                sell_price: 0,
                min_price: 0,
                deleted: 0
            };

            var product_data = [];
            loadCampaign();
            loadData();

            $("#save-btn").click(function () {
                if (new_product.front_shirt) {
                    new_product.product_color_id = $("#ProductColor").val();
                    $.ajax({
                        type: "POST",
                        url: "/campaign/add-product/" + new_product.campaign_id,
                        data: {
                            product: new_product
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.success) {
                                window.location = data.redirect_url;
                            } else {
                                alert(data.message);
                            }
                        },
                        failure: function (errMsg) {
                            alert(errMsg);
                        }
                    });
                }
            });

            function loadProductCombo() {
                $.each(product_data, function (k, v) {
                    $('#ProductName').append('<option value="' + v.id + '">' + v.name + '</option>');
                });
                loadColor($('#ProductName').val());
            }

            function loadColor(product_id) {
                $('#ProductColor').empty();
                var product = $(product_data).filter(function () {
                    return this.id == product_id;
                })[0];
                if (product.colors.length > 0) {
                    $.each(product.colors, function (k, v) {
                        if(k == 0) { new_product.product_color_id = v.id }
                        $('#ProductColor').append('<option value="' + v.id + '">' + v.color_name + '</option>');
                    });
                    loadData();
                }
                else {
                    $('#ProductColor').append('<option value="">ไม่มีสินค้า</option>');
                }
            }

            $("#price").val("$" + $("#slider").slider("value"));

            $('#ProductName').change(function () {
                loadColor($(this).val());
            });

            function loadData() {
                $(".shirt-front-preview").attr("src", new_product.image_front.full_path);

                if(new_product.front_shirt == 1 && new_product.product_color_id != null) {
                    $("#save-btn").removeAttr("disabled");
                }
                else {
                    $("#save-btn").attr("disabled", true);
                }
            }

            /*
             Load product data to JSON Object
             */
            function loadCampaign() {
                $.ajax({
                    type: "GET",
                    url: "/campaign/data/" + new_product.campaign_id,
                    dataType: "json",
                    success: function (data) {
                        campaign = data;
                        loadProductData();
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            function loadProductData() {
                if (product_data.length <= 0) {
                    $.ajax({
                        type: "POST",
                        url: "/product/all-products",
                        data: {
                            used_color: campaign.used_color
                        },
                        dataType: "json",
                        success: function (data) {
                            product_data = data.products;
                            loadProductCombo();
                        },
                        failure: function (errMsg) {
                            alert(errMsg);
                        }
                    });
                }
                else {
                    loadProductCombo();
                }
            }


            $('#front-preview-form').on('submit', (function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                $("#image-front-preview").val("");
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.result) {
                            new_product.image_front = data.file;
                            new_product.front_shirt = 1;
                            loadData();
                        }
                    },
                    error: function (data) {
                        console.log("error");
                        console.log(data);
                    }
                });
            }));

            $('#image-front-preview').on("change", function () {
                $("#front-preview-form").submit();
            });
        });
    </script>
@stop
@section('css')
    <style type="text/css" media="screen">
        .product-img img {
            max-width: 100px;
        }
        .box-image img {
            width: 100%;
        }
    </style>
@stop
@section('content')
    <div class="row" id="add-product" data-campaign-id="{{ $campaign_id }}">
        <div class="col-sm-12 col-md-12">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="box-image ">
                                    <img data-default="{{ asset('images/upload-art.jpg') }}" alt=""
                                         class="img-responsive shirt-front-preview">

                                    <p class="text-center">อัพโหลดรูปเสื้อที่มีลายอยู่บนเสื้อ
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="box-set">
                            <label class="title">ทำรูปเสื้อ (Mockup)</label>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <p>
                                        <strong class="text-primary">
                                            1. ออกแบบ</strong><br>
                                        <a class="btn btn-default btn-sm" href="/SF-Tee.zip">
                                            <i class="fa fa-download"></i> ดาวน์โหลดรูปเสื้อ และไฟล์ .psd
                                        </a>
                                        &nbsp;
                                        <a href="{{ url('design') }}" target="new" class="btn btn-default btn-sm">
                                            <i class="glyphicon glyphicon-globe"></i> ออกแบบบนเว็บ
                                        </a>
                                    </p>

                                    <p>
                                        <strong class="text-primary">2.วางลายให้ตรง</strong>
                                        บริเวณตำแหน่งสำหรับพิมพ์เสื้อ
                                    </p>

                                    <p>
                                        <strong class="text-primary">3. บันทึก</strong> เป็นไฟล์ JPG
                                    </p>
                                </li>
                            </ul>

                            <br>

                            <div class="form-group">
                                <label class="title" for="">อัพโหลดรูปเสื้อ</label>
                                <br>

                                <p>
                                    <label for="image-front-preview" class="btn btn-primary btn-lg">
                                        อัพโหลดรูปเสื้อ
                                    </label>
                                </p>

                                <form action="{{ action('AssociateController@postUploadShirt') }}" method="POST"
                                      id="front-preview-form" enctype="multipart/form-data">
                                    <input
                                            id="image-front-preview" type="file" name="image"
                                            style="display:none;"></form>
                                <br>

                                <label class="title" for="ProductName">เลือกเสื้อที่ต้องการขาย</label>
                                <select id="ProductName" name="ProductName" class="form-control">
                                </select>
                                <br>
                                <label class="title" for="ProductColor">เลือกสีเสื้อ</label>
                                <select id="ProductColor" name="ProductColor" class="form-control">

                                </select>

                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{ action('AssociateController@getEditCampaign', $campaign_id) }}"
                                   class="next btn btn-default-shadow btn-lg btn-block">
                                    <i class="fa fa-times"></i> ยกเลิก
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="javascript:void(0)" class="btn btn-success btn-lg btn-block" id="save-btn" disabled>
                                    <i class="fa fa-check"></i> บันทึก
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@stop

