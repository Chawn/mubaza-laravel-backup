@extends('layouts.full_width')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('script')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"></script>
    <script src="{{ asset('ckeditor-custom/ckeditor.js') }}"></script>
    <script src="https://cdn.omise.co/omise.js"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var order = {
                cart_id: '',
                payment_type_id: '',
                omise_token: '',
                shipping_type_id: '',
                shipping_data: {
                    full_name: ''
                    ,
                    address: '',
                    building: '',
                    district: '',
                    province: '',
                    zipcode: '',
                    phone: '',
                    email: ''
                },
                coupon_code: '',
                coupon_discount_total: 0
            };

            $('#shipping-form').validate({
                errorPlacement: function (error, element) {
                    // Append error within linked label
                    $(element).addClass('error');
                }
            });

            $("input[name=payment_type_id]").click(function () {
                var type = $(this).val();

                if (type == "card") {
                    $("#info-payment").removeClass("hidden");
                }
                else {
                    $("#info-payment").addClass("hidden");
                }
            });
            $("#apply-btn").click(function () {
                var element = $("#coupon-code-input");
                var target = $(".basket-total");
                var cart = store.get("cart");
                $.ajax({
                    type: "POST",
                    url: "/order/redeem-coupon",
                    data: {
                        cart_id: cart.session_id,
                        coupon_code: element.val()
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            $(".error-text").hide();
                            target.find("#discount-total").html("-฿" + data.coupon_discount_total);
                            target.find("#discount-total").attr("data-total", data.coupon_discount_total);
                            order.coupon_code = data.coupon_code;
                            order.coupon_discount_total = data.coupon_discount_total;
                            updateTotal();
                        } else {
                            target.find("#discount-total").html("฿0");
                            target.find("#discount-total").attr("data-total", 0);
                            order.coupon_code = "";
                            order.coupon_discount_total = 0;
                            updateTotal();
                            $(".error-text").show();
                            $(".error-text").html(data.message);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            });

            $("#btn-submit").click(function () {
                var payment_type = $("input[name=payment_type_id]:checked");
                if(!saveData()) {
                    console.log(order);
                    return false;
                }

                if(payment_type.val() == "transfer")
                {
                    submitOrder();
                } else {
                    $("#card-form").submit();
                }
            });

            $("input[name=shipping_type_id]").click(function() {
                var type = $(this).val();

                updateShippingCost($(".basket-total"), type);
            });

            function updateShippingCost(element, type) {
                if(!store.has("cart"))
                {
                    element.find("#shipping-cost").html("0");
                    return false;
                }

                var cart = store.get("cart");
                $.ajax({
                    type: "GET",
                    url: "/order/shipping-cost/" + cart.session_id + "/" + type,
                    success: function (data) {
                        if(data.success) {
                            element.find("#shipping-cost").html("฿" + data.cost);
                            element.find("#shipping-cost").attr("data-total", data.cost);
                            updateTotal();
//                            element.find("#total").html("฿" + (parseInt(data.cost) + parseInt(element.find("#total").data("total"))));
                        } else
                        {
                            element.html("0");
                            console.log(data.message);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            function updateTotal() {
                var element = $(".basket-total");

                var shipping_cost = parseFloat(element.find("#shipping-cost").attr("data-total"));
                var discount_total = parseFloat(element.find("#discount-total").attr("data-total"));
                var order_total = parseFloat(element.find("#order-total").attr("data-total"));

                var total = (order_total + shipping_cost) - discount_total;
                element.find("#order-total").html("฿" + (order_total + shipping_cost));
                element.find("#total").attr("data-total", total);
                element.find("#total").html("฿" + total);

                console.log(order);
            }
            updateShippingCost($(".basket-total"), $("input[name=shipping_type_id]").val());

            function saveData() {
                var name = $("#shipping-form").find("input[name=full_name]");

                if(name.val() == "")
                {
                    name.addClass("error");
                    name.focus();
                    return false;
                }
                name.removeClass("error");

                order.shipping_data.full_name = name.val();

                var address = $("#shipping-form").find("#address");

                if(address.val() == "")
                {
                    address.addClass("error");
                    address.focus();
                    return false;
                }
                address.removeClass("error");

                order.shipping_data.address = address.val();

                order.shipping_data.building = $("#shipping-form").find("input[name=building]").val();


                var district = $("#shipping-form").find("input[name=district]");

                if(district.val() == "")
                {
                    district.addClass("error");
                    district.focus();
                    return false;
                }
                district.removeClass("error");

                order.shipping_data.district = district.val();

                var province = $("#shipping-form").find("select[name=province]");

                if(province.val() == "")
                {
                    province.addClass("error");
                    province.focus();
                    return false;
                }
                province.removeClass("error");

                order.shipping_data.province = province.val();

                var zipcode = $("#shipping-form").find("input[name=zipcode]");

                if(zipcode.val() == "")
                {
                    zipcode.addClass("error");
                    zipcode.focus();
                    return false;
                }
                zipcode.removeClass("error");

                order.shipping_data.zipcode = zipcode.val();

                var email = $("#shipping-form").find("input[name=email]");

                if(email.val() == "")
                {
                    email.addClass("error");
                    email.focus();
                    return false;
                }
                email.removeClass("error");

                order.shipping_data.email = email.val();

                var phone = $("#shipping-form").find("input[name=phone]");

                if(phone.val() == "")
                {
                    phone.addClass("error");
                    phone.focus();
                    return false;
                }
                phone.removeClass("error");

                order.shipping_data.phone = phone.val();

                order.shipping_type_id = $("input[name=shipping_type_id]:checked").val();
                order.payment_type_id = $("input[name=payment_type_id]:checked").val();

                order.cart_id = $("#btn-submit").data("cart-id");

                return true;
            }

            function submitOrder() {
                if(!saveData()) {
                    return false;
                }

                if(order.payment_type_id == "card") {
                    order.omise_token = $("#card-form").find("input[name=omise_token]").val();
                }

                $.ajax({
                    type: "POST",
                    url: "/order/checkout/" + order.cart_id,
                    data: {
                        data: order
                    },
                    dataType: "json",
                    success: function (data) {
                        if(data.success) {
                            window.location = data.redirect_url;
                        } else
                        {
                            alert(data.message);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            Omise.setPublicKey('{{ env('OMISE_PUBLIC_KEY') }}');
            $("#card-form").submit(function () {

                var form = $(this);

                // Disable the submit button to avoid repeated click.
                form.find("input[type=submit]").prop("disabled", true);

                // Serialize the form fields into a valid card object.
                var card = {
                    "name": form.find("[data-omise=holder_name]").val(),
                    "number": form.find("[data-omise=number]").val(),
                    "expiration_month": form.find("[data-omise=expiration_month]").val(),
                    "expiration_year": form.find("[data-omise=expiration_year]").val(),
                    "security_code": form.find("[data-omise=security_code]").val()
                };

                // Send a request to create a token then trigger the callback function once
                // a response is received from Omise.
                //
                // Note that the response could be an error and this needs to be handled within
                // the callback.
                Omise.createToken("card", card, function (statusCode, response) {
                    if (response.object == "error") {
                        // Display an error message.
                        $('#token_errors').removeClass('hidden');
                        $("#token_errors").html(response.message);

                        // Re-enable the submit button.
                        form.find("input[type=submit]").prop("disabled", false);
                    } else {
                        // Then fill the omise_token.
                        form.find("[name=omise_token]").val(response.id);
                        // And submit the form.
//                        form.get(0).submit();
                        submitOrder();
                    }
                });

                // Prevent the form from being submitted;
                return false;

            });
        });
    </script>
@stop
@section('css')
    <style>
        label.error {
            color: #ff0000;
            border: 0px;
            padding: 0px;
        }

        input.error, textarea.error {
            border-color: red;
        }

        #show-card-cost {
            visibility: hidden;
        }

        .product-image {
            width: 50%;
            display: inline-block;
            float: left;
        }

        #cke_1_contents {
            height: 300px !important;
        }
        .text-block{
            display: block;
        }
        #collapse-coupon .well {
            margin-top: 10px;
        }
        .error-text {
            color: #ff0000;
        }
    </style>
@stop
@section('progress-step')
    @include('layouts.include.checkout-progress')
@stop
@section('content')
    <div id="checkout" class="row">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div id="checkout-process">
                <div id="step1" class="panel box-noneborder ">
                    <div class="panel-heading">
                        ชื่อที่อยู่ผู้รับสินค้า
                    </div>
                    <div class="panel-body">
                        <form id="shipping-form" method="post">
                            <fieldset class="address">
                                <div>
                                    <table class="table-form">
                                        <tr>
                                            <td><span class="text-danger">*</span> ชื่อ - สกุล:</td>
                                            <td><input class="form-control" type="text" name="full_name" id="full_name"
                                                       required
                                                       value="{{ \Auth::user()->check() ? \Auth::user()->user()->full_name : ''}}"
                                                       placeholder="ชื่อและนามสกุล"></td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-danger">*</span> ที่อยู่:</td>
                                            <td><textarea class="form-control" cols="30" rows="3" name="address"
                                                          id="address" required
                                                          placeholder="บ้านเลขที่, หมู่ที่, ถนน, ซอย, ตำบล">{{ \Auth::user()->check() ? \Auth::user()->user()->profile->address : '' }}</textarea>
                                            </td>
                                        </tr>{{-- 
                                        <tr>
                                            <td>อาคาร:</td>
                                            <td><input class="form-control" type="text" name="building" id="building"
                                                       value="{{ \Auth::user()->check() ? \Auth::user()->user()->profile->building : ''}}"
                                                       placeholder="อาคาร"></td>
                                        </tr> --}}
                                        <tr>
                                            <td><span class="text-danger">*</span>เขต/อำเภอ:</td>
                                            <td><input class="form-control" type="text" name="district" id="district"
                                                       required
                                                       value="{{ \Auth::user()->check() ? \Auth::user()->user()->profile->district : ''}}"
                                                       placeholder="เขต/อำเภอ"></td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-danger">*</span> จังหวัด:</td>
                                            <td>
                                                <select name="province" id="province" class="form-control" id="province"
                                                        required>
                                                    @foreach(Config::get('constant.provinces') as $province)
                                                        <option value="{{ $province }}" {{ \Auth::user()->check() ? \Auth::user()->user()->profile->province == $province ? 'selected' : '' : ''}}>{{ $province }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-danger">*</span> รหัสไปรษณีย์:</td>
                                            <td><input class="form-control" type="number" name="zipcode" id="zipcode"
                                                       value="{{ \Auth::user()->check() ? \Auth::user()->user()->profile->zipcode : ''}}"
                                                       placeholder="รหัสไปรษณีย์" required></td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-danger">*</span> เบอร์โทรศัพท์:</td>
                                            <td><input class="form-control" type="text" name="phone" id="phone"
                                                       value="{{ \Auth::user()->check() ? \Auth::user()->user()->profile->phone : ''}}"
                                                       placeholder="หมายเลขโทรศัพท์" required></td>
                                        </tr>{{-- 
                                        <tr>
                                            <td><span class="text-danger">*</span> อีเมล:</td>
                                            <td><input class="form-control" type="email" name="email" id="email"
                                                       value="{{ \Auth::user()->check() ? \Auth::user()->user()->email : ''}}"
                                                       placeholder="อีเมล" required></td>
                                        </tr> --}}
                                    </table>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div id="step3" class="panel">
                    <div class="panel-heading">
                        วิธีการจัดส่ง
                    </div>
                    <div class="panel-body">
                        @foreach($shipping_types as $key => $shipping_type)
                            <div class="radio">
                                <label>
                                    <input type="radio" name="shipping_type_id" class="shipping-type"
                                           id="{{ $shipping_type->name }}"
                                           value="{{ $shipping_type->name }}"
                                            {{ $key == 0 ? 'checked' : '' }} >
                                    {{ $shipping_type->detail }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="step2" class="panel">
                <div class="panel-heading">
                    วิธีการชำระเงิน
                </div>
                <div class="panel-body">
                    <div id="tabs">
                        <ul class="radio-tabs list-unstyled">
                            <li id="tab-1" class="tab">
                                <label class="payment-type">
                                    <input id="radio-bank" name="payment_type_id" type="radio" class="payment_type"
                                           value="transfer" checked/>
                                    โอนเงินผ่านธนาคาร
                                    <div class="pull-right">

                                    </div>
                                </label>
                            </li>
                            <li id="tab-2" class="tab">
                                <label class="payment-type">
                                    <input id="radio-card" name="payment_type_id" type="radio" class="payment_type"
                                           value="card"/>
                                    จ่ายผ่านบัตรเครดิต/เดบิต
                                    <div class="pull-right">
                                        <img src="{{ asset('images/icon/visa.png') }}" width="50" height="30">
                                        <img src="{{ asset('images/icon/mastercard.png') }}" width="50" height="30">
                                    </div>
                                </label>
                            </li>
                        </ul>
                        <form class="form-horizontal" id="card-form" method="post"
                              action="{{ action('OrderController@postCheckout', $cart->session_id) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div id="info-payment" class="hidden">
                                <div class="clear-fix">&nbsp;</div>
                                <div class="alert alert-danger hidden" id="token_errors"></div>

                                <input type="hidden" name="omise_token" class="form-control">

                                <div class="form-group">
                                    <label for="holder_name"
                                           class="col-sm-3 control-label mobile-hidden">ชื่อผู้ถือบัตร:</label>

                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Card holder name"
                                               data-omise="holder_name" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="number"
                                           class="col-sm-3 control-label mobile-hidden">หมายเลขบัตร:</label>

                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Card number"
                                               data-omise="number" class="form-control" min="16" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="expiration"
                                           class="col-sm-3 control-label mobile-hidden">วันหมดอายุ:</label>

                                    <div class="col-sm-3 margin-mobile">
                                        <input type="text" data-omise="expiration_month" size="8" placeholder="MM"
                                               class="form-control" value="">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" data-omise="expiration_year" size="8" placeholder="YYYY"
                                               class="form-control" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="security_code" class="col-sm-3 control-label mobile-hidden">รหัสความปลอดภัย:</label>

                                    <div class="col-sm-3">
                                        <input type="text" placeholder="CVV"
                                               data-omise="security_code" size="8" class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div id="overall" class="panel">
                <div class="panel-heading">
                    <i class="fa fa-shopping-cart"></i>
                    สรุปการสั่งซื้อ
                </div>
                <div class="panel-body">
                    <div class="basket-total">
                        <p><b id="product-name"></b></p>

                        <div class="basket-items">
                            @foreach($cart->items()->groupBy('product_sku_id')->get() as $item)
                                <p>{{ $item->product->color->product->name }}&nbsp;
                                    {{ $item->product->color->color_name }}&nbsp;ขนาด&nbsp;{{ $item->sku->size }}
                                    &nbsp;{{ $item->qty }}&nbsp;ตัว
                                    <span class="pull-right">฿{{ $item->total() }}</span>
                                </p>
                            @endforeach
                        </div>
                        <hr>
                        <p><b>ค่าจัดส่ง: </b><span class="pull-right" id="shipping-cost" data-total="0">฿0</span></p>
                        <p><b>รวม<span class="pull-right"><span id="order-total" data-total="{{ $cart->total() }}">฿{{ $cart->total() }}</span></span></b>
                        <p><b>ส่วนลด: </b><span class="pull-right" id="discount-total" data-total="0">฿0</span></p>
                        <p><b>รวมสุทธิ<span class="pull-right"><span id="total" data-total="{{ $cart->total() }}">฿{{ $cart->total() }}</span></span></b>
                        <hr>
                        <a class="text-block" data-toggle="collapse" href="#collapse-coupon" aria-expanded="false" aria-controls="collapse-coupon">ใช้คูปองส่วนลด</a>
                        <span class="error-text hidden pull-right"></span>
                        <div id="collapse-coupon" class="collapse">
                            
                                <div class="input-group" id="coupon-form">
                                    <input type="text" class="form-control" placeholder="ใส่รหัสคูปอง" id="coupon-code-input">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" id="apply-btn">ยืนยัน</button>
                                    </span>
                                </div>
                                
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    ต้องการความช่วยเหลือ?
                </div>
                <div class="panel-body">
                    ติดต่อเราได้ทุกวัน 8:30 - 17:30 น.
                    <br>
                        <i class="fa fa-phone-square"></i> {{ config('profile.phone-primary') }}
                    <br>
                        <a href="{{ config('profile.facebook') }}" class="link-reset">
                            <i class="fa fa-facebook-square"></i> GG7
                        </a>
                    
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="pull-right">
                <a href="javascript:void(0)" id="btn-submit" class="btn btn-success btn-medium" data-cart-id="{{ $cart->session_id }}"><i
                            class="fa fa-check-circle"></i>&nbsp;ดำเนินการต่อ</a>
            </div>
        </div>
    </div>
@stop