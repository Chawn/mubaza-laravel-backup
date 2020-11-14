@extends('layouts.full_width')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('script')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"></script>
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var campaign_data = null;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#close-date").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd/mm/yy',
                isBuddhist: true,
                dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
                dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
                monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.']
            });

            $("input").bind("keypress", function (e) {
                if (e.keyCode == 13) {
                    var inps = $("input, select"); //add select too
                    for (var x = 0; x < inps.length; x++) {
                        if (inps[x] == this) {
                            while ((inps[x]).name == (inps[x + 1]).name) {
                                x++;
                            }
                            if ((x + 1) < inps.length) $(inps[x + 1]).focus();
                        }
                    }
                    e.preventDefault();
                }
            });
            $("select").bind("keypress", function (e) {
                if (e.keyCode == 13) {
                    var inps = $("input, select"); //add select too
                    for (var x = 0; x < inps.length; x++) {
                        if (inps[x] == this) {
                            while ((inps[x]).name == (inps[x + 1]).name) {
                                x++;
                            }
                            if ((x + 1) < inps.length) $(inps[x + 1]).focus();
                        }
                    }
                    e.preventDefault();
                }
            });

            var all_products = [];

            function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
            }

            $("#toggle-location").click(function () {
                $("#front").toggleClass('hidden');
                $("#back").toggleClass('hidden');
                $(".toggle-look").toggleClass('hidden');
            });


            $("#select-product").hide();
            $("#new-product").click(function () {
                $("#select-product").toggle();
            });
            loadCampaign();
            loadCategory();
            loadProduct('all');

            function loadCategory() {
                $.each(all_products, function (k, v) {
                    $('#select-category').append('<option value="' + v.id + '">' + v.detail + '</option>');
                });
                getProduct($('#select-category').val());
            }

            $('#select-category').change(function () {
                getProduct($(this).val());
            });

            function getProduct(category_id) {
                var category = null;
                $('#product').empty();
                if (category == "") {
                    $('#product').append('<option value="">ไม่มีสินค้า</option>');
                }
                else {
                    category = $(all_products).filter(function () {
                        return this.id == category_id;
                    })[0];
                    if (category.products.length > 0) {
                        $.each(category.products, function (k, v) {
                            $('#product').append('<option value="' + v.id + '">' + v.name + '</option>');
                        });
                    }
                    else {
                        $('#product').append('<option value="">ไม่มีสินค้า</option>');
                    }
                }

            }

            $('#cat-id').change(function () {
                loadProduct($('#cat-id').val());
            });
            function loadProduct(category_id) {
                $.ajax({
                    type: "POST",
                    url: $('#get-product-by-category').val(),
                    data: {
                        "category_id": category_id
                    },
                    dataType: "json",
                    success: function (data) {
                        $('#product-id').empty();
                        if (data.length <= 0) {
                            $('#add-product').attr('disabled', 'disabled');
                            $('#product-id').append('<option>ไม่มีสินค้า</option>');
                        } else {
                            $.each(data, function (key, value) {
                                $('#add-product').removeAttr('disabled');
                                $('#product-id').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            function getRealPrice(product_id, element) {
                $.ajax({
                    type: "POST",
                    url: "/sell/real-price/" + product_id + "/" + campaign_data.design.front_design + "/" + campaign_data.design.back_design,
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        element.val(data.price);
                        element.attr('min', data.price);
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            $('input[name=end]').change(function () {
                if ($('input[name=end]:checked').val() == 1) {
                    $('#close-date').closest('tr').removeClass('hidden');
                }
                else {
                    $('#close-date').closest('tr').addClass('hidden');
                }
            });
            $('#end-amount').change(function () {
                var end_amount = $('#end-amount');
                if (end_amount.val() == 'customize') {
                    $('#close-date').closest('tr').removeClass('hidden');
                }
                else {
                    $('#close-date').closest('tr').addClass('hidden');
                }
            });

            $('#close-date').change(function () {
                var current_date = moment($('#close-date').attr('data-current-date'), 'DD/MM/YYYY');
                var choose_date = moment($('#close-date').val(), 'DD/MM/YYYY');
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
            $('#add-product').click(function () {
                var id = $("#product-id").find(":selected").val();
                var used_color = $("#used_color").attr('data-color');
                if ($('.row-product').length < 10) {
//                    addProduct(id);
                    addRowProduct($('#select-category').val(), $('#product').val());
                    $("#minimum-produce").html(0);
                } else {
                    alert("สำนวนสินค้าที่คุณขายได้สูงสุดคือ 10 แบบ");
                }
            });

            function addRowProduct(category_id, product_id) {
                var category = $(all_products).filter(function () {
                    return this.id == category_id;
                })[0];

                var product = $(category.products).filter(function () {
                    return this.id == product_id;
                })[0];
                var row_html = '';
                if (product != undefined) {
                    var image = null;
                    $.each(product.image, function (k, v) {
                        if (checkDuplicateProduct(v.id)) {
                            image = v;
                            return false;
                        }
                    });

                    if (image == null) {
                        alert("ไม่มีสีในสินค้าแบบนี้แล้ว");
                        return false;
                    }

                    row_html += '<div class="row-product row-price-' + product.id + '" data-product-id="' + product.id + '" ' +
                            'data-name="' + product.name + '" data-image-id="' + image.id + '" ' +
                            'data-unit-price="' + product.price + '" ' +
                            'data-image-url="' + image.image_front + '">' +
                            '<div class="column col-image">' +
                            '<img class="product_image" src="' + image.image_front + '" style="width:40px">' +
                            '</div><div class="column col-color">' +
                            '<div class="btn-group"><button data-color="' + image.color + '" ' +
                            'style="background-color:' + image.color + ';"' +
                            'class="selected-color btn-color btn-lg dropdown-toggle" data-image-id="' + image.id + '"' +
                            'data-image-front="' + image.image_front + '" data-toggle="dropdown" aria-expanded="false"></button>' +
                            '<div id="dropdown-color" class="dropdown-color dropdown-menu" role="menu">';
                    $.each(product.image, function (k, v) {
                        if (image.id != v.id) {
                            row_html += '<div class="new-color btn-color btn-lg" data-image-front="' + v.image_front + '" ' +
                                    'data-color="' + v.color + '" data-image-id="' + v.id + '" style="background-color:' + v.color + ';"></div>';
                        }
                    });

                    row_html += '</div></div></div>' +
                            '<div class="column col-name">' + product.name + '</div><div class="column col-price spinner-none">';
                    if ($('.row-price-' + product.id).attr('data-product-id') == undefined) {
                        row_html += '<input type="number" class="form-control input-price price-' + product.id + '" name="sell_price" max="10000" ';
                    }
                    else {
                        row_html += '<input type="number" class="form-control input-price price-' + product.id + ' disabled" name="sell_price" max="10000" ';
                    }
                    row_html += 'min="' + product.price + '"></div>' +
                            '<div class="column col-trash"><a class="trash"><i class="fa fa-times"></i></a></div></div>';
                    $('#product-selected').append(row_html);
                    baseEventProduct();
                    getRealPrice(product.id, $('.row-price-' + product.id).find('.input-price'));
                }
            }


            function refreshInputPrice() {
                var product_id = [];
                $('.row-product').each(function () {

                    if (product_id[$(this).attr('data-product-id')] == undefined) {
                        product_id[$(this).attr('data-product-id')] = $(this).attr('data-product-id');
                        $(this).find('.input-price').removeClass('disabled');
                    }
                    else {
                        $(this).find('.input-price').addClass('disabled');
                    }
                });
            }

            function baseEventProduct() {
                $(".new-color").unbind("click");
                $(".input-price").unbind("change");
                $('body').off('.trash');
                $('body').off('.input-price');
                $(".new-color").click(function () {
                    change_color($(this));
                });
                $(".trash").click(function () {
                    $(this).closest('.row-product').remove();
                    refreshInputPrice();
                });
                $('.input-price').keyup(function () {
                    var product_id = $(this).closest('.row-product').attr('data-product-id');
                    $('.price-' + product_id).val($(this).val());
                    if (parseInt($(this).val()) > parseInt($(this).attr("min"))) {
                    }
                });
            }

            function change_color(new_color_btn) {
                if (checkDuplicateProduct(new_color_btn.attr('data-image-id'))) {
                    var new_color = new_color_btn.attr('data-color');
                    var new_image = new_color_btn.attr('data-image-front');
                    var new_image_id = new_color_btn.attr('data-image-id');
                    var selected_btn = new_color_btn.closest('.btn-group').find(".selected-color");

                    var selected_image = new_color_btn.attr('data-image-front');
                    var current_color = selected_btn.attr('data-color');
                    var current_image = selected_btn.attr('data-image-front');
                    var current_image_id = selected_btn.attr('data-image-id');
                    new_color_btn.css('background-color', current_color);

                    new_color_btn.attr('data-color', current_color);
                    new_color_btn.attr('data-image-front', current_image);
                    new_color_btn.attr('data-image-id', current_image_id);
                    selected_btn.css('background-color', new_color);

                    selected_btn.attr('data-color', new_color);
                    selected_btn.attr('data-image-front', new_image);
                    selected_btn.attr('data-image-id', new_image_id);
                    selected_btn.closest('div.row-product').attr('data-image-id', new_image_id);
                    var product_image = new_color_btn.closest('.row-product').find(".product_image");

                    product_image.attr("src", new_image);
                } else {
                    alert('สินค้านี้มีอยู่แล้วกรุณาเลือกใหม่');
                }
            }

            function checkDuplicateProduct(id) {
                var result = true;
                $('.row-product').each(function () {
                    if ($(this).attr('data-image-id') == id) {
                        result = false;
                        return false;
                    }
                });

                return result;
            }

            function loadCampaign() {
                var hash_id = getHashID();
                var key = hash_id[0] + '/' + hash_id[1];
                var campaign = parseOut(key);
                campaign_data = campaign.campaign;
                $('#product-selected').attr('data-block-count', parseInt(campaign.campaign.block_front_count) + parseInt(campaign.campaign.block_back_count));
                var product = campaign.campaign.product[0];
                all_products = campaign.products;
                $('#main-product #front').html('<img src="/' + campaign.campaign.base_folder + campaign.campaign.thumbnail_front + '" />');
                $('#main-product #back').html('<img src="/' + campaign.campaign.base_folder + campaign.campaign.thumbnail_back + '" />');
                $('#img-front-product').attr('src', "/" + campaign.campaign.base_folder + campaign.campaign.thumbnail_mini_front);
                $('#img-back-product').attr('src', "/" + campaign.campaign.base_folder + campaign.campaign.thumbnail_mini_back);
                var designed_product = $('#designed-product');
                designed_product.addClass('row-price-' + product.id);
                designed_product.attr('data-product-id', product.id);
                designed_product.attr('data-color', product.color);
                designed_product.attr('data-unit-price', product.price);
                designed_product.attr('data-image-url', product.image_url);
                designed_product.attr('data-name', product.name);
                designed_product.attr('data-image-id', product.image_id);
                designed_product.find('.product_image').attr('src', "/" + campaign.campaign.base_folder +  campaign.campaign.thumbnail_mini_front);
                designed_product.find('.profit').attr('id', 'profit-' + product.id);
                getRealPrice(product.id, designed_product.find('.input-price'));
                baseEventProduct();
                $('#product-name').append(product.name);
                $("#used_color.selected-color").css('background', product.color);
                $("#used_color.selected-color").attr('data-color', product.color);
                $("#used_color.selected-color").attr('data-color-name', product.color_name);

            }

            $('#img-front-product').click(function () {
                $('#back').addClass('hidden');
                $('#front').removeClass('hidden');
            });
            $('#img-back-product').click(function () {
                $('#front').addClass('hidden');
                $('#back').removeClass('hidden');
            });
            $('#goal').keyup(function () {
                var goal = $(this);
                if (parseInt(goal.val()) > 2000) {
                    alert('คุณสามารถตั้งเป้าหมายได้ไม่เกิน 2,000 ตัว');
                    goal.val('2000');
                }
                else {
                    setTimeout(function () {
                    }, 1500);
                }
            });

            function getHashID() {
                var url_hash = window.location.hash;
                var key = '';
                var hash_id = new Hashids("mubaza");
                if (url_hash == "") {
                    key = hash_id.encode(Date.now());
                    return [key, 0];
                }
                else {
                    var url_split = url_hash.split('/');
                    return [url_split[1], url_split[2]];
                }
            }

            $("#save-goal").click(function () {
                if ($('#goal-form').valid()) {
                    updateCampaignGoal();
                }
            });
            function updateCampaignGoal() {
                var hash_id = getHashID();
                var key = hash_id[0] + '/' + hash_id[1];
                var campaign = parseOut(key);
                var products = campaign.campaign.product;
                var new_products = [];
                var error = false;
                campaign.campaign.goal = $('#goal').val();
                campaign.campaign.limit = $('#limit').val();
                var end_amount = $('input[name=end]:checked').val();
                if (end_amount == '1') {
                    var current_date = moment($('#close-date').attr('data-current-date'), 'DD/MM/YYYY');
                    var choose_date = moment($('#close-date').val(), 'DD/MM/YYYY');
                    campaign.campaign.end_amount = choose_date.diff(current_date, 'd');
                }
                else {
                    campaign.campaign.end_amount = parseInt(end_amount);
                }
                new_products.push(products[0]);
                $.each($('.row-product'), function (index) {
                    var min_sell_price = parseInt($(this).find('.input-price').attr('min'));
                    var max_sell_price = parseInt($(this).find('.input-price').attr('max'));
                    var sell_price = parseInt($(this).find('.input-price').val());
                    if (sell_price >= min_sell_price && sell_price < max_sell_price) {
                        if (index > 0) {
                            var product_image_id = $(this).attr('data-image-id');
                            var data = $(products).filter(function () {
                                return this.image_id == product_image_id;
                            })[0];
                            if (new_products[0].image_id == product_image_id) {
                                data = null;
                            }
                            if (data == undefined) {
                                var product = {
                                    id: $(this).attr('data-product-id'),
                                    name: $(this).attr('data-name'),
                                    image_url: $(this).attr('data-image-url'),
//                                    unit_price: parseInt($(this).attr('data-unit-price')),
                                    sell_price: sell_price,
                                    color: $(this).find('.selected-color').attr('data-color'),
                                    image_id: $(this).attr('data-image-id')
                                };
                                new_products.push(product);
                            }

                        }
                        else {
//                            new_products[0].unit_price = parseInt($(this).attr('data-unit-price'));
                            new_products[0].sell_price = sell_price;
                        }
                    }
                    else if (sell_price >= max_sell_price) {
                        alert('ราคาสินค้าสูงเกินไป ฉันคิดว่าคงไม่มีใครซื้อมันหรอกนะ');
                        error = true;
                        return false;
                    }
                    else if (sell_price < min_sell_price) {
                        alert('ไม่สามารถตั้งราคาตำกว่าราคาขั้นต่ำที่กำหนดไว้');
                        error = true;
                        return false;
                    }
                });
                if (!error) {
                    campaign.campaign.product = new_products;
                    console.log(campaign.campaign);
                    var next_key = hash_id[0] + '/' + (parseInt(hash_id[1]) + 1);
                    parseIn(next_key, campaign);
                    setUrl(next_key);

                    window.location = $('#next-url').val() + "#!/" + next_key;
                }
            }

            function parseOut(key) {
                return JSON.parse(localStorage.getItem(key));
            }

            function parseIn(key, data) {
                localStorage.setItem(key, JSON.stringify(data))
            }

            function setUrl(key) {
                window.location.hash = "!/" + key;
            }

            $('#goal-form').validate({
                rules: {
                    goal: {
                        required: true,
                        number: true
                    },
                    sell_price: {
                        required: true,
                        number: true
                    }
                },
                errorPlacement: function (error, element) {
                    // Append error within linked label
                    $(element).addClass('error');
                }
            });

        });
    </script>
@stop
@section('css')
    <style type="text/css" media="screen">
        .input-price {
            width: 55px !important;
            padding: 5px 0 5px 5px;
        }

        .column {
            vertical-align: middle;
            padding: 1px;
        }

        .col-image {
            width: 50px;
        }

        .col-color {
            width: 50px;
        }

        .col-name {
            width: 220px;
        }

        .col-price {
            width: 80px;
        }

        .col-profit {
            width: 80px;
            text-align: center;
        }

        .col-trash {
            margin-left: 10px;
        }

        .col-cat-option {
            width: 160px;
        }

        .col-product-option {
            width: 210px;
        }

        #main-product {

        }

        #main-product img {
            max-width: 100%;
        }

        #main-product img#preview {
            position: absolute;
            z-index: 1;
        }

        #set-goal .profit {

        }

        .profit-total {
            font-size: 30px;
        }

        .set-goal-table .topic {
            width: 120px;
        }

        #product-selected .column {
            display: table-cell;
        }

        .error {
            border-color: #f00;
        }

        input.disabled {
            pointer-events: none;
            color: #AAA;
            background: #F5F5F5;
        }
    </style>
@stop
@section('content')
    <div id="set-goal">
        <div class="row">
            <div class="col-md-6">
                <div id="main-product">
                    <div id="front"></div>
                    <div id="back" class="hidden"></div>
                </div>
                <div id="toggle-location">
                    <div class="toggle-look">
                        ดูด้านหลัง
                    </div>
                    <div class="toggle-look hidden">
                        ดูด้านหน้า
                    </div>
                    <img class="look-back" src="{{ asset('images/icon/look-back.png') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="wrapper">
                        <div class="title">ตั้งเป้าการขาย</div>
                        <div class="detail">
                            <input name="_token" id="token" type="hidden" value="{{ csrf_token() }}"/>
                            <input name="get-category" id="get-category" type="hidden"
                                   value="{{ action('ProductController@postProductCategory') }}"/>
                            <input name="get-product-by-category" id="get-product-by-category" type="hidden"
                                   value="{{ action('ProductController@postGetProductByCategory') }}"/>
                            <input name="get-product-by-id" id="get-product-by-id" type="hidden"
                                   value="{{ action('ProductController@postGetRowProduct') }}"/>
                            <input name="next-url" type="hidden" id="next-url"
                                   value="{{ action('SellController@getSetDetail') }}"/>

                            <form action="#" id="goal-form">
                                <table class="table-form set-goal-table">
                                    <tr>
                                        <td class="topic">เป้าหมาย</td>
                                        <td>
                                            <div class="column spinner-none">
                                                <input type="number" id="goal"
                                                       class="form-control" name="goal"
                                                       min="10"
                                                       value="10" placeholder="ต่ำสุด 10">

                                            </div>
                                            <div class="column">ตัว</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="topic">จำนวนสูงสุด</td>
                                        <td>
                                            <div class="column spinner-none">
                                                <input type="number" id="limit"
                                                       class="form-control" name="limit"
                                                       min="0"
                                                       value="0">

                                            </div>
                                            <div class="column">ตัว</div>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <div class="description">
                                เมื่อระยะเวลาเปิดขายสิ้นสุดลง แต่การขายน้อยกว่าเป้าหมาย อย่างไรก็ตาม เรายังคงผลิตให้
                                หากมีจำนวนผู้สั่งซื้อมากพอที่จะคุณจะได้กำไร
                            </div>
                        </div>
                    </div>
                    <div class="wrapper set-price">
                        <div class="title">เลือกสินค้าและตั้งราคา</div>
                        <div class="detail">
                            <div id="product-selected">
                                <div class="head-row-product">
                                    <div class="column col-image">
                                        สินค้า
                                    </div>
                                    <div class="column col-color">

                                    </div>
                                    <div class="column col-name"></div>
                                    <div class="column col-price">
                                        ตั้งราคา
                                    </div>
                                </div>
                                <div class="row-product" id="designed-product">
                                    <div class="column col-image">
                                        <img class="product_image" src=""
                                             style="width:40px">
                                    </div>
                                    <div class="column col-color">
                                        <div class="btn-group">
                                            <button id="used_color"
                                                    class="selected-color btn-color btn-lg dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="column col-name" id="product-name"></div>
                                    <div class="column col-price spinner-none">
                                        <input type="number" class="form-control input-price" name="sell_price"
                                               placeholder="" value="" max="10000">
                                    </div>
                                </div>
                            </div>
                            <div class="wrapper new-product">
                                <a id="new-product">เพิ่มสินค้าแบบอื่น</a>

                                <div id="select-product" class="row-fluid">
                                    <div class="column col-cat-option">
                                        <select name="select_category" id="select-category" class="form-control">
                                        </select>
                                    </div>
                                    <div class="column col-product-option">
                                        <select name="product" id="product" class="form-control">
                                        </select>
                                    </div>
                                    <div class="column">
                                        <button name="add_product" id="add-product" type="button"
                                                class="btn btn-primary"> +
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="set-goal-table">
                            <tbody>
                            <tr>
                                <td class="topic">ระยะเวลาเปิดขาย</td>
                                <td>
                                    <input type="radio" name="end" id="no" value="0" checked>&nbsp;ไม่มี
                                </td>
                                <td>
                                    <input type="radio" name="end" id="customize" value="1">&nbsp;กำหนดเวลา
                                </td>
                            </tr>
                            <tr class="hidden">
                                <td>กำหนดเวลาสิ้นสุด</td>
                                <td colspan="2"><input type="text" name="close_date" id="close-date"
                                                       data-current-date="{{ \Carbon::now()->format('d/m/Y') }}"
                                                       placeholder="เวลาสิ้นสุด"
                                                       class="form-control"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="clear-fix">&nbsp;</div>
                <div class="wrapper">
                    <button type="submit" id="save-goal" class="btn btn-success btn-medium"><i class="fa fa-check"></i>&nbsp;ต่อไป
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop