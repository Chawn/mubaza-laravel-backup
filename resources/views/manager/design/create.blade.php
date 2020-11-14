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
            $("#slider").slider({
                value: 390,
                min: 390,
                max: 590,
                step: 1,
                slide: function (event, ui) {
                    $("#price").val(ui.value);
                    campaign.products.sell_price = ui.value;
                    $("#profit-creator").html(parseInt(ui.value*0.08));
                    $("#profit-all").html(parseInt(ui.value*0.21));
                }
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
            // Initialize new campaign object
            var campaign = null;

            loadData();

            loadProductData();
            loadCategoryData();
            $(".box-step").hide();

            $("#step1").show();

            $(".next").click(function () {
                var target = $(this).attr('data-target');
                $(".box-step").hide();
                $("#step" + target).show();
                $(".nav-step.active").toggleClass('active');
                $("#nav-" + target).addClass('active')
            });

            $("#price").on("change", function() {
                var element = $(this);
                var min = parseInt(element.attr("min"));
                var max = parseInt(element.attr("max"));
                if(element.val() == "" || element.val() < min) {
                    element.val(min);
                } else if(element.val() > max) {
                    element.val(max);
                }
                var slider = $("#slider");
                slider.slider("value", element.val());
            });
            function updateSlider() {
                var slider = $("#slider");
                var product_id = $("#ProductName").val();
                var product = $(campaign.product_data).filter(function () {
                    return this.id == product_id;
                })[0];

                var min = 0;
                var max = parseInt(product.max_price);

                if (campaign.both_print) {
                    min = parseInt(product.two_side_price);
                }
                else {
                    min = parseInt(product.one_side_price);
                }

                slider.slider("option", "min", min);
                slider.slider("option", "max", max);
                slider.slider("option", "value", min);
                $("#min-price").html("฿" + min);
                $("#max-price").html("฿" + max);
                var price_input = $("#price");
                price_input.val(min);
                price_input.attr("min", min);
                price_input.attr("max", max);

                $("#profit-creator").html(parseInt(min*0.08));
                $("#profit-all").html(parseInt(min*0.21));
                
                campaign.products.sell_price = min;
            }

            function initialize() {
                campaign = {
                    id: 1,
                    title: "",
                    description: "",
                    goal: 0,
                    url: null,
                    end_amount: null,
                    start: null,
                    end: null,
                    is_recommended: 0,
                    campaign_category_id: 0,
                    campaign_type_id: null,
                    campaign_status_id: null,
                    front_art: 1,
                    upload_front_art: 0,
                    image_front: '',
                    upload_image_front: {
                        full_path: $("#front-art-preview").attr("data-default"),
                        path: '',
                        file_name: {
                            large: '',
                            thumbnail: ''
                        }
                    },
                    user_id: 0,
                    remark: null,
                    deleted_at: null,
                    created_at: null,
                    updated_at: null,
                    products: {
                        id: null,
                        campaign_id: null,
                        product_color_id: null,
                        front_shirt: 0,
                        upload_image_front: {
                            full_path: $(".shirt-front-preview").attr("data-default"),
                            path: '',
                            file_name: {
                                large: '',
                                thumbnail: ''
                            }
                        },
                        image_front: '',
                        small_image_front: '',
                        medium_image_front: '',
                        large_image_front: '',
                        sell_price: 0,
                        min_price: 0,
                        deleted: 0
                    },
                    tags: "",
                    expired_at: null,
                    product_data: [],
                    category_data: []
                };

                campaign.expired_at = moment().add(1, 'days').format("DD/MM/YYYY HH:mm");
                store('campaign', campaign);

            }

            function loadData() {

                if (!store.has('campaign')) {
                    initialize();
                }
                else {
                    campaign = store('campaign');
                    var expire = moment(campaign.expired_at, "DD/MM/YYYY HH:mm");
                    var now = moment();
                    if (expire.diff(now, 'hours') <= -0) {
                        initialize();
                    }
                }
                if (campaign.upload_image_front == null) {
                    $('#front-art-preview').attr("src", $("#front-art-preview").attr("data-default"));
                } else {
                    $('#front-art-preview').attr("src", campaign.upload_image_front.full_path);
                }


                $('.shirt-front-preview').attr("src", campaign.products.upload_image_front.full_path);
                if (campaign.upload_front_art == 1) {
                    $("#step1-btn").removeAttr("disabled");
                    if (campaign.products.front_shirt == 1) {
                        $("#step2-btn").removeAttr("disabled");
                    }
                }

                // Detail section load

                $("#title").val(campaign.title);
               /* CKEDITOR.instances.description.setData(campaign.description);*/
                $("#tags").val(campaign.tags);

                if (campaign.end == null) {
                    $("#no-limit").prop("checked", true);
                    $("#select-end-date").addClass("hidden");
                }
                else {
                    $("#limit").prop("checked", true);
                    $("#select-end-date").removeClass("hidden");
                    $("#endDate").val(campaign.end);
                }
            }

            function saveData() {
                campaign.products.product_color_id = $("#ProductColor").val();

                store('campaign', campaign);
                loadData();
            }

            function loadProductCombo() {
                $.each(campaign.product_data, function (k, v) {
                    $('#ProductName').append('<option value="' + v.id + '">' + v.name + '</option>');
                });
                loadColor($('#ProductName').val());
            }

            function loadCategoryCombo() {
                var selected_category = campaign.campaign_category_id;
                var category_combo = $("#category");
                if (selected_category == 0) {
                    category_combo.val(selected_category);
                }

                $.each(campaign.category_data, function (k, v) {
                    category_combo.append('<option value="' + v.id + '">' + v.detail + '</option>');

                    if (v.id == selected_category) {
                        category_combo.val(selected_category);
                    }
                });
            }

            $('#ProductName').change(function () {
                loadColor($(this).val());
            });


            $("#step3-btn").click(function () {
                if ($("#title").val() == "") {
                    alert("คุณจำเป็นต้องมีชื่อสินค้า");
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
                    else {
                        campaign.end = $("#endDate").val();
                    }
                }
                else {
                    campaign.end = null;
                }

                if (!$('#agree-tos').prop('checked')) {
                    alert('คลิ๊กเพื่อยอมรับข้อตกลงสำหรับการใช้งาน');
                    $("#agree-tos").focus();
                    return false;
                }
                campaign.title = $("#title").val();
                campaign.description = CKEDITOR.instances.description.getData();
                campaign.campaign_category_id = $("#category").val();
                campaign.tags = $("#tags").val();
                campaign.back_cover = $("input[name=cover]:checked").val();
                saveData();

                saveCampaign();
            });

            $("input[name=limit_time]").change(function () {
                if ($('input[name=limit_time]:checked').val() == 1) {
                    $("#select-end-date").removeClass("hidden");
                } else {
                    campaign.end = null;
                    $("#select-end-date").addClass("hidden");
                }
            });

            $("#endDate").change(function () {
                var end_date = $("#endDate");
                var current_date = moment();
                var choose_date = moment(end_date.val(), 'DD/MM/YYYY');
                var diff_day = parseInt(choose_date.diff(current_date, 'd'));
                console.log(diff_day);
                if (current_date.isAfter(choose_date) || current_date.isSame(choose_date)) {
                    alert('ไม่สามารถเลือกเป็นวันปัจจุบันได้');
                    $('#close-date').val(current_date.add(7, 'd').format('DD/MM/YYYY'));
                }
                if (diff_day > 30) {
                    alert('ไม่สามารถกำหนดวันที่สิ้นสุดเกิน 30 วันได้');
                    $('#close-date').val(current_date.add(7, 'd').format('DD/MM/YYYY'));
                }
            });

            $("#step2-btn").click(function(){
                if ($('#ProductColor').val()=='') {
                    $("#step2").css('display', 'block');
                    $("#step3").css('display', 'none');
                    $('#ProductColor').focus();
                    alert('ยังไม่ได้เลือกสีเสื้อ');
                };
            })

            function loadColor(product_id) {
                $('#ProductColor').empty();
                $('#ProductColor').html('<option value="">เลือกสีเสื้อ</option>');
                var product = $(campaign.product_data).filter(function () {
                    return this.id == product_id;
                })[0];
                if (product.colors.length > 0) {
                    $.each(product.colors, function (k, v) {
                        $('#ProductColor').append('<option value="' + v.id + '">' + v.color_name + '</option>');
                    });
                    updateSlider();
                }
                else {
                    $('#ProductColor').append('<option value="">ไม่มีสินค้า</option>');
                }
            }

            function waitButton(element, wait_text) {
                element.attr("disabled", true);
                element.html('<i class="fa fa-spinner fa-pulse"></i>&nbsp;' + wait_text);
            }

            function finishButton(element, original_text) {
                element.removeAttr("disabled");
                element.html(original_text);
            }

            /*
             Save campaign to dabase
             */

            function saveCampaign() {
                $.ajax({
                    type: "POST",
                    url: "../campaign/save",
                    data: {
                        campaign: campaign
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.result) {
                            $("#step4").show();
                            $("#step3").hide();
                            $("#nav-3").removeClass("active");
                            $("#nav-4").addClass("active");
                            $("#show-btn").attr("href", data.show_url);
//                            $("#edit-btn").attr("href", data.edit_url);
                            store.clear("campaign");
                        }
                        else {
                            alert(data.message);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            /*
             Load product data to JSON Object
             */

            function loadProductData() {
                if (campaign.product_data.length <= 0) {
                    $.ajax({
                        type: "POST",
                        url: "../product/all-products",
                        dataType: "json",
                        success: function (data) {
                            campaign.product_data = data.products;
                            saveData();
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

            function loadCategoryData() {
                if (campaign.category_data.length <= 0) {
                    $.ajax({
                        type: "GET",
                        url: "../campaign-category/all",
                        dataType: "json",
                        success: function (data) {
                            campaign.category_data = data;
                            saveData();
                            loadCategoryCombo();
                        },
                        failure: function (errMsg) {
                            alert(errMsg);
                        }
                    });
                }
                else {
                    loadCategoryCombo();
                }
            }

            /*
             AJAX Upload
             */

            $('#front-art-form').on('submit', (function (e) {
                waitButton($("label[for=image-front-art]"), "กำลังอัพโหลด");

                e.preventDefault();
                var formData = new FormData(this);
                $("#image-front-art").val("");
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.result) {
                            campaign.upload_image_front = data.file;
                            campaign.upload_front_art = 1;
                            $("#remove-front-art").removeClass("hidden");
                            saveData();
                        } else {
                            alert(data.message);
                        }
                        finishButton($("label[for=image-front-art]"), "เลือกไฟล์ (.png เท่านั้น)");
                    },
                    error: function (data) {
                        console.log("error");
                        console.log(data);
                    }
                });
            }));
            $('#front-preview-form').on('submit', (function (e) {
                waitButton($("label[for=image-front-preview]"), "กำลังอัพโหลด");
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
                            campaign.products.upload_image_front = data.file;
                            campaign.products.front_shirt = 1;
                            saveData();
                        } else {
                            alert(data.message);
                        }
                        finishButton($("label[for=image-front-preview]"), "เลือกไฟล์ (.jpg เท่านั้น)");
                    },
                    error: function (data) {
                        console.log("error");
                        console.log(data);
                    }
                });
            }));

            $("#image-front-art").on("change", function () {
                $("#front-art-form").submit();
            });
            $('#image-front-preview').on("change", function () {
                $("#front-preview-form").submit();
            });
        });
    </script>
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('datetimepicker-master/jquery.datetimepicker.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/selectize/selectize.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/selectize/selectize.bootstrap3.css') }}"/>
    <style type="text/css" media="screen">

        .create-nav .navbar-nav li a {
            font-weight: 700;
        }

        .create-nav .navbar-nav li.active > a {
            font-weight: 800;
            background-color: #F0AD4E;
            color: #eee;
        }

        .breadcrumb-design {
            margin-top: -30px;
        }

        .remove-btn {
            margin-right: 10px;
            cursor: pointer;
        }

        .btn.disabled {
            display: none;
        }

        .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
            cursor: default;
            color: #777;
        }

        
        .box-image img{
            width: 100%;
        }
        @media(max-width: 767px){
            #creat-mainnav .nav{
                margin:auto;
            }
            .btn-primary .btn-lg{
                font-size: 13px;
            }
            .btn-block{
                margin-bottom: 15px;
            }
        }
    </style>
@stop
@section('content')
    <nav id="creat-mainnav" class="navbar navbar-design-step navbar-default navbar-static-top">
        <ul class="nav navbar-nav">
            <li id="nav-1" class="nav-step active">
                <a href="#">
                    <strong>1. อัพโหลดลายเสื้อ <i class="fa fa-chevron-right"></i></strong>
                </a>
            </li>
            <li id="nav-2" class="nav-step ">
                <a href="#">
                    <strong>2. อัพโหลดรูปเสื้อ <i class="fa fa-chevron-right"></i></strong>
                </a>
            </li>
            <li id="nav-3" class="nav-step ">
                <a href="#">
                    <strong>3. ใส่รายละเอียด <i class="fa fa-chevron-right"></i></strong>
                </a>
            </li>
            <li id="nav-4" class="nav-step ">
                <a href="#">
                    <strong>4. สำเร็จ <i class="fa fa-chevron-right"></i></strong>
                </a>
            </li>
        </ul>
    </nav>
    <div id="step1" class="box-step box-create">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mockup text-center">
                        <div class="upload-frame">
                            <img id="front-art-preview" class="thumbnail img-responsive" src="{{ asset('images/upload-art.jpg') }}"  alt="" >
                        </div>

                        <br>
                        <h4 class="text-center"><strong>อัพโหลดลายเสื้อ</strong></h4>
                        <div class="example-box text-center">
                            
                        </div>
                    </div>
                    <div class="box-image  front-art-panel hidden">
                        <img id="front-art-preview" data-default="{{ asset('images/upload-art.jpg') }}" alt=""
                             class="img-responsive">

                        <p class="text-center">
                            <i class="fa fa-trash remove-btn pull-right hidden"
                               id="remove-front-art"
                               data-target="#front-art-preview"></i>
                        </p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box-set">
                        
                        <label class="title">เพื่อผลลัพธ์ที่ดีที่สุด</label>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p>
                                    <strong class="text-info">Template</strong>:
                                   <a href="{{ asset('resources/GG7-Art-Template.psd') }}" target="new" class="btn btn-default">
                                        Download Art Template .psd <i class="fa fa-download"></i>
                                    </a>
                                </p>
                                <p>
                                    <strong class="text-info">ขนาดภาพ</strong>:
                                    <strong class="text-danger">
                                        กว้าง 2400px * สูง 3200px
                                    </strong>
                                </p>
                                <p>
                                    <strong class="text-info">ประเภทไฟล์</strong>
                                    : .png
                                </p>
                                <p>
                                    <strong class="text-info">ขนาดไฟล์สูงสุด</strong>
                                    : 5MB
                                </p>
                                <p>
                                    <strong class="text-info">ตัวอย่าง</strong>
                                    :
                                    <img class="image-example" src="{{ asset('images/example-art.png') }}" height="80" alt="">
                                </p>
                            </li>
                        </ul>
                        <br>
                        <label class="title">ข้อควรทราบ</label>
                        <ol>
                            <li>เราจะใช้รูปภาพนี้ในการพิมพ์ลงบนเสื้อ รูปภาพนี้จะต้องไม่มีรูปอื่นๆ นอกจากลายที่ต้องการพิมพ์</li>
                            <li>รูปภาพจะต้องมีพื้นหลังโปร่งใส เพราะถ้ามีสี เราก็จะพิมพ์สีนั้นลงบนเสื้อด้วย</li>
                        </ol>
                    </div>
                    <br>
                    <label class="title">อัพโหลดลายเสื้อ</label>
                    <p class="">
                    <label for="image-front-art" class="btn btn-primary btn-lg"> 
                        เลือกไฟล์ (.png เท่านั้น)
                    </label>
                    <form action="{{ action('AssociateController@postUpload') }}" method="POST" id="front-art-form"
                          enctype="multipart/form-data"><input
                                id="image-front-art" type="file" name="image"
                                style="display:none;"></form>
                    </p>
                    <br>
                    
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-4 col-sm-offset-8">
                    <button data-target="2" class="next btn-control btn btn-success btn-lg btn-block"
                            id="step1-btn">
                        ต่อไป <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="step2" class="box-step box-create">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="upload-frame">
                        <img data-default="{{ asset('images/upload-art.jpg') }}" alt=""
                             class="thumbnail img-responsive shirt-front-preview">
                    </div>
                    <br>
                    <h4 class="text-center"><strong>อัพโหลดรูปเสื้อตัวอย่าง</strong></h4>
                </div>
                <div class="col-sm-6">
                    <div class="box-set">
                        <div class="form-group">
                            <label class="title">วิธีสร้างรูปเสื้อตัวอย่าง</label>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <strong class="text-info">Template</strong>:
                                    <a class="btn btn-default" href="{{ asset('resources/GG7-Mockup.psd') }}">
                                        Download Mockup .psd <i class="fa fa-download"></i>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <strong class="text-info">
                                       การออกแบบ
                                    </strong>:
                                    จัดวางลายให้อยู่ในพื้นที่กำหนด
                                </li>
                                <li class="list-group-item">
                                    <strong class="text-info">Save เป็นไฟล์</strong>
                                    : .jpg เท่านั้น
                                </li>
                                <li class="list-group-item">
                                    <strong class="text-info">ตัวอย่าง</strong>
                                    : <img class="image-example" src="{{ asset('images/example-mockup.png') }}" height="80" alt="">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <br>
                    <label class="title" for="">อัพโหลดรูปเสื้อตัวอย่าง</label>
                    <p>
                        <label for="image-front-preview" class="btn btn-primary btn-lg" id="upload-front-preview">
                            เลือกไฟล์ (.jpg เท่านั้น)
                        </label>
                    </p>
                    <br>
                    <label class="title" for="ProductName">เลือกแบบเสื้อ</label>
                    <select id="ProductName" name="ProductName" class="form-control">
                    </select>
                    <br>
                    <label class="title" for="ProductColor">สี</label>
                    <select id="ProductColor" name="ProductColor" class="form-control">

                    </select>
                    <p class="text-danger">
                        <strong>
                        เลือกสีเสื้อให้ตรงกับรูปเสื้อตัวอย่าง
                        </strong>
                    </p>
                    <form action="{{ action('AssociateController@postUploadShirt') }}" method="POST"
                          id="front-preview-form" enctype="multipart/form-data">
                        <input
                                id="image-front-preview" type="file" name="image"
                                style="display:none;"></form>
                    <br>
                        <label class="title" for="price">ราคา:</label>
                        <div class="input-group">
                          <span class="input-group-addon">฿</span>
                          <input type="number" id="price" class="form-control">
                        </div>
                    <br>
                        
                    <div class="row">
                        <div class="col-sm-6">
                            <strong class="text-orange" id="min-price" >
                            </strong>
                        </div>
                        <div class="col-sm-6">
                            <strong class="text-orange pull-right" id="max-price">
                            </strong>
                        </div>
                    </div>
                    <div id="slider"></div>

                </div>
                
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-4">
                    <button data-target="1" class="next btn btn-default-shadow btn-lg btn-block">
                        <i class="fa fa-arrow-circle-left"></i> ย้อนกลับ
                    </button>
                </div>
                <div class="col-sm-4 col-sm-offset-4">
                    <button data-target="3" class="next btn btn-success btn-lg btn-block" id="step2-btn" disabled
                    >
                        ต่อไป <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="step3" class="box-step box-create">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="box-image">
                        <img data-default="{{ asset('images/upload-art.jpg') }}"
                             class="thumbnail img-responsive shirt-front-preview">

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box-set">
                        <label class="title" for="title">ชื่อสินค้า</label>
                        <input id="title" name="title" class="form-control" maxlength="40" required>

                        <p>
                            <small>ควรใช้ภาษาอังกฤษ และไม่เกิน 40 ตัวอักษร</small>
                        </p>

                        <br>
                        <label class="title" for="category">หมวดหมู่</label>
                        <select id="category" name="category" class="form-control" required>
                            <option value="0">เลือกหมวดหมู่สินค้า</option>
                        </select>
                        <br>
                        <label class="title" for="description">รายละเอียด</label><br>
                        <textarea name="description" id="description" class="form-control description" rows="3"
                                  required></textarea>

                        <p>
                            <small>บอกเรื่องราว ที่มา หรือความหมาย เพื่อเพิ่มความน่าสนใจให้กับสินค้า</small>
                        </p>
                        <script>
                            CKEDITOR.replace('description');
                        </script>
                        <br>
                        <label class="title" for="tags">แท็ก</label>
                        <input type="text" class="form-control" id="tags" name="campaign_tags" required>

                        <p>
                            <small>สามารถใส่ได้สูงสุด 5 แท็ก ขั้นแต่ละคำด้วย "," (คอมม่า) เช่น แมว, แมวสีขาว, Cat, White
                                Cat
                                <br><strong class="">ใช้คำที่เกี่ยวข้องกับลาย</strong>
                                จะช่วยให้ลูกค้าค้นหาเจอได้ง่ายขึ้นบนเว็บของเรา และจากเว็บค้นหาอื่นๆ
                            </small>
                        </p>
                        <hr>
                    </div>
                    <input type="hidden" name="limit_time" id="no-limit" value="0" checked>
                    {{-- <br>
                    <label class="title">ตัวเลือก</label>
                    <div class="box-set">
                        <label class="title">กำหนดวันสิ้นสุด</label>
                        <div class="checkbox">
                            <p>
                                <label>
                                    <input type="radio" name="limit_time" id="no-limit" value="0" checked>
                                    ไม่มีวันสิ้นสุด (ค่าเริ่มต้น)
                                </label>
                            </p>

                            <p>
                                <label>
                                    <input type="radio" name="limit_time" id="limit" value="1">
                                    ใช้งานวันสิ้นสุด <span
                                            class="text-danger">*</span>
                                </label>
                            </p>
                        </div>
                        <div class="form-group hidden" id="select-end-date">
                            <label class="title">เลือกวันสิ้นสุด</label>
                            <input class="form-control" id="endDate" type="text" name="endDate" value="">
                        </div>

                        <small><strong class="text-danger">* การกำหนดวันสิ้นสุด</strong> หมายถึง
                            สินค้าของคุณจะเปิดขายเพียงช่วงระยะเวลาหนึ่ง เมื่อถึงระยะเวลาสิ้นสุดที่คุณกำหนด
                            การขายจะถูกปิดลงโดยอัตโนมัติ
                        </small>
                    </div>
                    <br> --}}
                    <p>
                        <label class="title">
                            <input type="checkbox" id="agree-tos" required>
                            &nbsp;ฉันได้อ่านและยอมรับ<a href="{{ url('help/terms') }}">ข้อตกลงการใช้งาน</a>
                        </label>
                    </p>

                    
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-4">
                    <button data-target="2" class="next btn btn-default-shadow btn-lg btn-block">
                        <i class="fa fa-arrow-circle-left"></i> ย้อนกลับ
                    </button>
                </div>
                <div class="col-sm-4 col-sm-offset-4">
                    <button class="btn btn-success btn-lg btn-block" id="step3-btn">
                        ต่อไป <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="step4" class="box-step box-create">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="box-image">
                        <img src="{{ asset('images/upload-art.jpg') }}" alt=""
                             class="thumbnail img-responsive shirt-front-preview">
                    </div>
                </div>
                <div class="col-sm-6">
                    <h2 class="text-center">เสร็จแล้ว!!</h2>
                    <a id="show-btn" class="btn btn-success btn-block btn-lg">
                        หน้าแสดงสินค้า <i class="fa fa-arrow-circle-right"></i>
                    </a>
                    <br>
                    <a href="{{ action('AssociateController@getDesign') }}" id="edit-btn" class="btn btn-default btn-block btn-lg">
                        <i class="fa fa-pencil-square-o"></i> จัดการสินค้าที่ออกแบบไว้
                    </a>
                    <br>

                    <br>
                </div>
            </div>

        </div>
    </div>
@stop