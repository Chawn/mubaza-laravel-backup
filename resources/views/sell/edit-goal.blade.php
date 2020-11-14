@extends('layouts.full_width')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var campaign = {
                products: []
            };
            function formatNumber (num) {
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
                $.ajax({
                    type: "POST",
                    url: $('#get-category').val(),
                    data: {
                        "_token": $('#token').val()
                    },
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            $('#cat-id').append('<option value="' + value.id + '">' + value.detail + '</option>');
                        });
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            $('#cat-id').change(function () {
                loadProduct($('#cat-id').val());
            });
            function loadProduct(category_id) {
                $.ajax({
                    method: 'GET',
                    url: './product/all-products',
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            var hash_data = getHashID();
                            var key = hash_data[0];
                            var item_no = hash_data[1];
                            var campaign = parseOut(key + '/' + item_no);
                            campaign.products = data.products;
                            parseIn(key + '/' + item_no, campaign);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            $('#add-product').click(function () {
                var id = $("#product-id").find(":selected").val();
                var used_color = $("#used_color").attr('data-color') ;
                if ($('.row-product').length < 10) {
                    addProduct(id,used_color);
                }else{
                    alert("สำนวนสินค้าที่คุณขายได้สูงสุดคือ 10 แบบ") ;
                };

            });


            function addProduct(id,used_color) {
                $.ajax({
                    type: "POST",
                    url: $('#get-product-by-id').val(),
                    data: {
                        "_token": $('#token').val(),
                        "id": id ,
                        "used_color": used_color
                    },
                    success: function (data) {
                        //console.log(data);
                        $("#product-selected").append(data['html']);
                        baseEventProduct();
                        calculate_cost();
                    },
                    dataType: "json",
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            function baseEventProduct(){
                $(".new-color").click(function () {
                    change_color($(this));
                });
                $(".trash").click(function () {
                    $(this).closest('.row-product').remove();
                     calculate_profit($(this).closest('.row-product').find('.input-price'));
                });
                $('.input-price').change(function () {
                    calculate_profit($(this));
                });
                $('.input-price').keyup(function () {
                    calculate_profit($(this));
                });
            }

            function change_color(new_color_btn) {
                alert("change_color:"+new_color_btn.attr('data-color'));
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

                //console.log(new_image);
                product_image.attr("src", new_image);
            }

            function loadCampaign() {

//                var hash_id = getHashID();
//                var key = hash_id[0] + '/' + hash_id[1];
//                var campaign = parseOut(key);
//                $('#product-selected').attr('data-block-count', parseInt(campaign.campaign.block_front_count) + parseInt(campaign.campaign.block_back_count));
//                var product = campaign.campaign.product;
//                $('#main-product #front').html('<img src="http://localhost/mubaza-laravel/public/' + campaign.campaign.thmb_front + '" />');
//                $('#main-product #back').html('<img src="http://localhost/mubaza-laravel/public/' + campaign.campaign.thmb_back + '" />');
//                $('#img-front-product').attr('src', 'http://localhost/mubaza-laravel/public/' + campaign.campaign.thmb_mini_front);
//                $('#img-back-product').attr('src', 'http://localhost/mubaza-laravel/public/' + campaign.campaign.thmb_mini_back);
//                var designed_product = $('#designed-product');
//                designed_product.attr('data-product-id', product.id);
//                designed_product.attr('data-color', product.color);
//                designed_product.attr('data-unit-price', product.price);
//                designed_product.attr('data-image-url', product.image_url);
//                designed_product.attr('data-name', product.name);
//                designed_product.find('.product_image').attr('src', 'http://localhost/mubaza-laravel/public/' + campaign.campaign.thmb_mini_front);
//                $('#product-name').append(product.name);
//                $("#used_color.selected-color").css('background', product.color);
//                $("#used_color.selected-color").attr('data-color', product.color);
//                $("#used_color.selected-color").attr('data-color-name', product.color_name);
//                calculate_cost();
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
                calculate_cost();
            });
            $('.input-price').keyup(function () {
                calculate_profit($(this));
            });
            $('#goal').change(function () {
                calculate_cost();
            });
            $('.input-price').change(function () {
                calculate_profit($(this));
            });

            function calculate_cost() {
                var hash_id = getHashID();
                var key = hash_id[0] + '/' + hash_id[1];
                var campaign = parseOut(key);

                var goal = parseInt($("#goal").val()) ;


                var unit_price = "";
                var product_cost = "" ;
                var block_count = "" ;
                var block_cost = "" ;
                var block_price = "" ;
                var minimum_price = 0 ;

                var block_count = parseInt($('#block_count').val()) ;
                var printing_unit_cost = parseInt($('#printing_cost').val());

                var block_cost = parseInt($('#block_cost').val());
                var printing_cost = (printing_unit_cost * block_count)*goal;

                console.log("block_count:"+block_count);
                console.log("printing_unit_cost:"+printing_unit_cost);
                console.log("block_cost:"+block_cost);
                console.log("printing_cost:"+printing_cost);

                $.each($('.row-product'), function (index) {
                    unit_price = parseInt($(this).attr('data-unit-price'));
                    goal = parseInt($('#goal').val());

                    product_cost = unit_price * goal;
                    var cost = block_cost + printing_cost + product_cost ;
                    var unit_cost = (block_cost+printing_cost)/goal ;

                    minimum_price = unit_price + unit_cost ;
                    $(this).find('.input-price').val(minimum_price);
                    /*if ($(this).find('.input-price').val()<=minimum_price) {
                        $(this).find('.input-price').val(minimum_price);
                    }*/
                    $(this).find('.input-price').attr('min', minimum_price);
                    calculate_profit($(this).find('.input-price'));
                });
            }

            function calculate_profit(input_price) {
                var goal = parseInt($('#goal').val());
                var parent = input_price.parents('.row-product');
                if (input_price.val() == "") {
                    input_price.val(0);
                }

                var profit = parseInt(input_price.val()) - parseInt(input_price.attr('min'));
                parent.find('.profit').text(formatNumber(profit));
                var lowest_profit = profit * goal;
                if ($('.row-product').length < 2) {
                    var profit_total = profit * goal;
                    $('#profit-total').text(formatNumber(profit_total));
                }
                else {
                    var profit_total = [];
                    $.each($('.row-product'), function (index) {
                        profit_total.push(parseInt($(this).find('.input-price').val() - parseInt($(this).find('.input-price').attr('min'))) * goal);
                    });
                    profit_total.sort(function (a, b) {
                        return b - a
                    });
                    if (profit_total[profit_total.length - 1] == 0 && profit_total[0] == 0) {
                        $('#profit-total').text('0');
                    } else {
                        if (parseInt(profit_total[profit_total.length - 1]) != parseInt(profit_total[0])) {
                            $('#profit-total').text(formatNumber(profit_total[profit_total.length - 1]) + ' - ' + formatNumber(profit_total[0]));
                        } else {
                            $('#profit-total').text(formatNumber(profit_total[profit_total.length - 1]));
                        }

                    }

                    console.log(profit_total);
                }

            }

            

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
                updateCampaignGoal();
            });
            function updateCampaignGoal() {
                var sub_products = [];
                var campaign = {
                    goal: 0,
                    end_amount: 0,
                    products: []
                };
                var error = false;
                campaign.goal = $('#goal').val();
                campaign.end_amount = $('#end-amount').val();
                $.each($('.row-product'), function (index) {
                    var min_sell_price = parseInt($(this).find('.input-price').attr('min'));
                    var max_sell_price = parseInt($(this).find('.input-price').attr('max'));
                    var sell_price = parseInt($(this).find('.input-price').val());
                    if (sell_price >= min_sell_price && sell_price < max_sell_price) {
                        var product = {
                            id: $(this).attr('data-product-id'),
                            name: $(this).attr('data-name'),
                            unit_price: parseInt($(this).attr('data-unit-price')),
                            sell_price: sell_price,
                            image_id: $(this).attr('data-image-id')
                        };
                        sub_products.push(product);
                    }
                    else if (sell_price >= max_sell_price) {
                        alert('ราคาสินค้าสูงเกินไป ฉันคิดว่าคงไม่มีใครซื้อมันหรอกนะ');
                        error = true;
                        return false;
                    }
                    else if (sell_price < min_sell_price){
                        alert('ไม่สามารถตั้งราคาตำกว่าราคาขั้นต่ำที่กำหนดไว้');
                        error = true;
                        return false;
                    }
                });
                console.log(sub_products);
                if (!error) {
                    campaign.products = sub_products;

                    $.ajax({
                        type: "POST",
                        url: $('#save-goal').data('url'),
                        data: {
                            "_token": $('#token').val(),
                            "campaign": campaign
                        },
                        success: function (data) {
                            if(!data.error)
                            {
                                console.log(data);
                                window.location = data.next_step;
                            }
                            else
                            {
                                alert('เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณลองใหม่');
                            }
                        },
                        dataType: "json",
                        failure: function (errMsg) {
                            alert(errMsg);
                        }
                    });
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
            width: 140px;
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
        .col-cat-option{
            width: 160px;
        }
        .col-product-option{
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
        #set-goal .profit{

        }
        .profit-total{
            font-size: 30px;
        }
        .set-goal-table .topic{
            width: 120px;
        }
        #product-selected .column{
            display: table-cell;
        }
    </style>
@stop
@section('content')
    <div id="set-goal">
        <h1>ตั้งเป้าการขาย</h1>

        <div class="row">
            <div class="col-md-6">
                <div id="main-product">
                    <div id="front"><img src="{{ $campaign->design->image_front_preview }}" alt="{{ $campaign->title }}"/></div>
                    <div id="back" class="hidden"><img src="{{ $campaign->design->image_back_preview }}"
                                                       alt="{{ $campaign->title }}"/></div>
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
                            <input name="block_price" type="hidden" id="block_cost"
                                   value="{{ config('constant.block_unit_cost') }}"/>
                            <input name="block_count" type="hidden" id="block_count"
                                   value="{{ $campaign->design->block_front_count + $campaign->design->block_back_count }}"/>
                            <input name="print_unit_cost" type="hidden" id="printing_cost"
                                   value="{{ config('constant.printing_unit_cost') }}"/>
                            <input name="get-category" id="get-category" type="hidden"
                                   value="{{ action('ProductController@postProductCategory') }}"/>
                            <input name="get-product-by-category" id="get-product-by-category" type="hidden"
                                   value="{{ action('ProductController@postGetProductByCategory') }}"/>
                            <input name="get-product-by-id" id="get-product-by-id" type="hidden"
                                   value="{{ action('ProductController@postGetRowProduct') }}"/>
                            <input name="next-url" type="hidden" id="next-url"
                                   value="{{ action('SellController@getSetDetail') }}"/>
                            <table class="table-form set-goal-table">
                                <tr>
                                    <td class="topic">เป้าหมาย</td>
                                    <td>
                                        <div class="column">
                                            <input type="number" id="goal" class="form-control" name="goal" min="5"
                                                   value="50" placeholder="ต่ำสุด 5">
                                        </div>
                                        <div class="column">ตัว</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="topic">ระยะเวลาเปิดขาย</td>
                                    <td>
                                        <select name="end_amount" id="end-amount" class="form-control">
                                            <option value="3">3 วัน ( สิ้นสุด {{ Date::now()->add('3 day')->format('j F') }} )
                                            </option>
                                            <option value="5">5 วัน ( สิ้นสุด {{ Date::now()->add('5 day')->format('j F') }} )
                                            </option>
                                            <option value="7">7 วัน ( สิ้นสุด {{ Date::now()->add('7 day')->format('j F') }} )
                                            </option>
                                            <option value="14">14 วัน ( สิ้นสุด  {{ Date::now()->add('14 day')->format('j F') }} )
                                            </option>
                                            <option value="21">21 วัน ( สิ้นสุด  {{ Date::now()->add('21 day')->format('j F') }} )
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <div class="description">
                                เมื่อระยะเวลาเปิดขายสิ้นสุดลง แต่การขายน้อยกว่าเป้าหมาย อย่างไรก็ตาม เรายังคงผลิตให้ หากมีจำนวนผู้สั่งซื้อมากพอที่จะคุณจะได้กำไร
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
                                    <div class="column col-profit">กำไร
                                    </div>
                                </div>
                                <div class="row-product" data-product-id="{{ $campaign->products->first()->product_id }}"
                                     data-name="{{ $campaign->products->first()->product->name }}"
                                     data-color="{{ $campaign->products->first()->product_image->color }}"
                                     data-image-id="{{ $campaign->products->first()->product_image_id }}"
                                     data-unit-price="{{ $campaign->products->first()->product->price }}"
                                     >
                                    <div class="column col-image">
                                        <img class="product_image" src="{{ $campaign->back_cover ? url('/') . '/' . $campaign->design->image_back_preview_thmb : url('/') . '/' . $campaign->design->image_front_preview_thmb }}"
                                             style="width:40px">
                                    </div>
                                    <div class="column col-color">
                                        <div class="btn-group">
                                            <button id="used_color" data-color="{{ $campaign->products->first()->product_image->color }}"
                                                    style="background-color:{{ $campaign->products->first()->product_image->color }};"
                                                    class="selected-color btn-color btn-lg dropdown-toggle"
                                                    data-image-id="{{ $campaign->products->first()->product_image_id }}"
                                                    data-image-front="{{ $campaign->products->first()->product_image->image_front }}"
                                                    data-toggle="dropdown"
                                                    aria-expanded="false"></button>
                                            @foreach($campaign->products->first()->product->image as $image)
                                            <div id="dropdown-color" class="dropdown-color dropdown-menu" role="menu">
                                                <div class="new-color btn-color btn-lg"
                                                     data-image-front="{{ $image->image_front_url }}"
                                                     data-color="{{ $image->color }}" data-image-id="{{ $image->id }}"
                                                     style="background-color:{{ $image->color }};">
                                                </div>
                                            </div>
                                                @endforeach
                                        </div>
                                    </div>
                                    <div class="column col-name" id="product-name">{{ $campaign->products[0]->product->name }}</div>
                                    <div class="column col-price">
                                        <input type="number" class="form-control input-price" name="" placeholder="" min="{{ $campaign->products[0]->min_price }}" value="{{ $campaign->products[0]->min_price }}" max="10000">
                                    </div>
                                    <div class="column col-profit"><span>฿<span class="profit">0</span>/ตัว</span></div>
                                </div>
                            </div>
                            <div class="wrapper new-product">
                                <a id="new-product">เพิ่มสินค้าแบบอื่น</a>

                                <div id="select-product" class="row-fluid">
                                    <div class="column col-cat-option">
                                        <select name="category_id" id="cat-id" class="form-control">
                                            <option value="all">ทั้งหมด</option>
                                        </select>
                                    </div>
                                    <div class="column col-product-option">
                                        <select name="product_id" id="product-id" class="form-control">
                                            <option value="">เลือกสินค้า</option>
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
                    </div>
                    <div class="wrapper">
                        <div class="title">กำไรที่คุณจะได้ เมื่อขายได้ตามเป้าหมาย</div>
                        <div class="detail">
                            <div class="profit-total text-success"><span id="profit-total"></span> บาท</div>
                        </div>
                    </div>

                </div>
                <br>

                <div class="wrapper">

                    <button type="submit" id="save-goal" data-url="{{ action('CampaignController@getEditGoal', $campaign->id) }}" class="btn btn-success btn-medium">บันทึกและไปต่อ</button>

                </div>
            </div>
        </div>
    </div>
@stop