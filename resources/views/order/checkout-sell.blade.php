@extends('layouts.full_width')
@section('css')
<style>
    .product-image{
        width: 100%;
        display: inline-block;
        float: left;
        z-index: 9;
    }
    #image-row{
        
    }
    div#image_front,div#image_back{
        position: relative;
        
    }
    .cover-image{
        z-index: 10;
    }
    .cover-image,.product-image{
        position: absolute;
        width: 100%;
        left: 0px;
        top: 0px;
    }
</style>
@stop
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>

    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"></script>
    <script src="{{ asset('ckeditor-custom/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#shipping-form').validate({
                errorPlacement: function (error, element) {
                    // Append error within linked label
                    $(element).addClass('error');
                }
            });

            

            $('#btn-submit').click(function () {
                if ($('#shipping-form').valid()) {
                    $(this).attr('disabled', 'disabled');
                    $(this).html('<i class="fa fa-spinner fa-pulse"></i>&nbsp;กรุณารอสักครู่');
                    var payment_type = '';
                    if ($('#radio-card:checked').val()) {
                        payment_type = $('#radio-card:checked').val();
                    }
                    else {
                        payment_type = $('#radio-bank:checked').val();
                    }
                    var shipping = {
                        full_name: $('#full_name').val(),
                        address: $('#address').val(),
                        building: $('#building').val(),
                        district: $('#district').val(),
                        province: $('#province').val(),
                        zipcode: $('#zipcode').val(),
                        phone: $('#phone').val(),
                        email: $('#email').val(),
                    };
                    $.ajax({
                        type: "POST",
                        url: 'confirm-order',
                        data: {
                            "_token": $('#token').val(),
                            "payment_type": payment_type,
                            "shipping_type": $('input[name=shipping_type_id]:checked').val(),
                            "shipping": shipping
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.result == 'success') {
                                window.location = data.redirect_url;
                            }

                            $(this).removeAttr('disabled');
                            $(this).html('<i class="fa fa-check"></i>&nbsp;ดำเนินการต่อ');
                        },
                        failure: function (errMsg) {
                            alert(errMsg);
                        }
                    });
                }
                else

                {
                    var body = $("html, body");
                    body.stop().animate({scrollTop:0}, '500', 'swing');
                }
            });

            /*$('#add-card').click(function() {
                if($('#add-card').is(':checked')) {
                    $('#card-input-wrapper').removeClass('hide');
                    $('#show-card-cost').removeClass('hide');
                    $("#total").attr('data-card-cost',$("#card-cost").attr('data-card-cost')) ;
                }
                else
                {   
                    $('#card-input-wrapper').addClass('hide');
                    $('#show-card-cost').addClass('hide');
                    $("#total").attr('data-card-cost',0) ;
                }
                cal_price() ;
            });*/

            $('.shipping-type').change(function () {
                $.ajax({
                        type: "GET",
                        url: './cal-shipping-cost/'+$(this).val(),
                        
                        dataType: "json",
                        success: function (data) {
                            $(".transport-cost").html(data.cost);
                            $("#total").attr('data-transport-cost',data.cost) ;
                            cal_price() ;
                        },
                        failure: function (errMsg) {
                            alert(errMsg);
                        }
                    });
            });

            function cal_price(){
                var transport = parseInt($("#total").attr('data-transport-cost'));
                var card =  parseInt($("#total").attr('data-card-cost'));
                var old_total =  parseInt($("#total").attr('data-order-total'));
                var total = transport+card+old_total ;

                $("#total").html(total);
            }
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

        input.error {
            border-color: red;
        }
        @media (max-width: 480px){
            
        }
    </style>
@stop
@section('content')
    <input name="_token" type="hidden" id="token" value="{{ csrf_token() }}"/>
    @if(!\Auth::user()->check())
        <h4 class="text-left"><a href="#" title="">เข้าสู่ระบบ</a> เพื่อความรวดเร็วในการสั่งซื้อ </h4>
    @endif
    <div id="checkout" class="row">
        <div id="process" class="col-md-8 col-xs-12">
            <div id="step1" class="box box-noneborder">
                <div class="box-title font-title">
                    ที่อยู่สำหรับจัดส่ง
                </div>
                <div class="content">
                    <form id="shipping-form" method="post">
                        <fieldset class="address">
                            <div>
                                <table class="table-form">
                                    <tr>
                                        <td><span class="text-danger">*</span> ชื่อ - สกุล:</td>
                                        <td><input class="form-control" type="text" name="name" id="full_name" required
                                                   value="{{ is_null(\Auth::user()->user()) ? '' : \Auth::user()->user()->full_name }}"
                                                   placeholder="ชื่อและนามสกุล"></td>
                                    </tr>
                                    <tr>
                                        <td><span class="text-danger">*</span> ที่อยู่:</td>
                                        <td><textarea class="form-control" cols="30" rows="3" name="address"
                                                      id="address" required
                                                      placeholder="บ้านเลขที่, หมู่ที่, ถนน, ซอย, ตำบล">{{ is_null(\Auth::user()->user()) ? '' : \Auth::user()->user()->profile->address }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>เขต/อำเภอ:</td>
                                        <td><input class="form-control" type="text" name="building" id="building"
                                                   value="{{ \Auth::user()->user()->profile->building }}"
                                                   placeholder="เขต/อำเภอ"></td>
                                    </tr>
                                    <tr>
                                        <td><span class="text-danger">*</span> อำเภอ:</td>
                                        <td><input class="form-control" type="text" name="district" id="district"
                                                   required
                                                   value="{{ is_null(\Auth::user()->user()) ? '' : \Auth::user()->user()->profile->district }}"
                                                   placeholder="อำเภอ"></td>
                                    </tr>
                                    <tr>
                                        <td><span class="text-danger">*</span> จังหวัด:</td>
                                        <td>
                                            <select name="province" id="province" class="form-control" id="province"
                                                    required>
                                                @foreach(Config::get('constant.provinces') as $province)
                                                    <option value="{{ $province }}" {{ \Auth::user()->user()->profile->province == $province ? 'selected' : ''}}>{{ $province }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="text-danger">*</span> รหัสไปรษณีย์:</td>
                                        <td><input class="form-control" type="number" name="zipcode" id="zipcode"
                                                   value="{{ is_null(\Auth::user()->user()) ? '' : \Auth::user()->user()->profile->zipcode }}"
                                                   placeholder="รหัสไปรษณีย์" required></td>
                                    </tr>
                                    <tr>
                                        <td><span class="text-danger">*</span> เบอร์โทรศัพท์:</td>
                                        <td><input class="form-control" type="text" name="phone" id="phone"
                                                   value="{{ is_null(\Auth::user()->user()) ? '' : \Auth::user()->user()->profile->phone }}"
                                                   placeholder="หมายเลขโทรศัพท์" required></td>
                                    </tr>
                                    <tr>
                                        <td><span class="text-danger">*</span> อีเมล:</td>
                                        <td><input class="form-control" type="email" name="email" id="email"
                                                   value="{{ is_null(\Auth::user()->user()) ? '' : \Auth::user()->user()->email }}"
                                                   placeholder="อีเมล" required></td>
                                    </tr>
                                </table>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div id="step3" class="box">
                <div class="box-title font-title">
                    เลือกวิธีการจัดส่ง
                </div>
                <div class="content" style="padding: 10px;">
                    
                    @foreach($shipping_types as $shipping_type)
                        <div class="radio">
                            <label>
                                <input type="radio" name="shipping_type_id" class="shipping-type" id="{{ $shipping_type->name }}" value="{{ $shipping_type->name }}" {{ $total_qty>=50 ? 'checked' : '' }}>
                                {{ $shipping_type->detail }}
                            </label>
                        </div>
                    @endforeach
                    <div class="row">
                        <span class="pull-right">
                            @if($total_qty>=50)
                                สั่งซื้อ 50 ชิ้นขึ้นไป จัดส่งฟรี!!
                            @else
                                ค่าจัดส่ง <span class="transport-cost">0</span> บาท
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <!--
            <div id="step4" class="box">
                <div class="box-title font-title">
                    เพิ่มการ์ดอวยพร
                </div>
                <div class="content" style="padding: 10px;">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="add_card" id="add-card"> เพิ่มการ์ดอวยพร
                        </label>
                    </div>
                    <div id="card-input-wrapper" class="hide">
                        <label for="card-content">ข้อความ</label>
                        <textarea name="card-content" id="card-content" cols="20" rows="5" class="form-control"></textarea>
                        <script>
                            CKEDITOR.replace('card-content');
                        </script>
                    </div>
                </div>
            </div>       
            -->     
        </div>
        <div id="basket" class="pull-right col-md-4 col-xs-12">
            <div class="box">
                <div class="box-title font-title">
                        <i class="fa fa-shopping-cart"></i>
                        รายการสินค้า
                </div>
                <div class="basket-total">                  
                    <p><b id="product-name">{{ $campaign->title }}</b></p>
                    <div class="basket-items row">

                        @foreach($order['items'] as $item)
                            <p>{{ $item['name'] }}&nbsp;{{ $item['color'] }}&nbsp;ขนาด&nbsp;{{ $item['size'] }}
                                    &nbsp;{{ $item['qty'] }}&nbsp;ตัว
                                <span class="pull-right">฿{{ $item['sub_total'] }}</span>
                            </p>
                        @endforeach
                    </div>
                    <!-- <p><a href="#">+ใส่รหัสคูปองส่วนลด</a></p>
                    <p>ราคาสินค้ารวม: ฿<span id="subtotal" class="pull-right">{{ $order['total'] }}</span></p> -->
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                <b>ค่าจัดส่ง: </b>
                                <span class="pull-right">฿<span id="transport-cost" class="transport-cost">0</span></span>
                            </p>
                            <p id="show-card-cost" class="hide">
                                <b>ค่าการ์ดอวยพร: </b>
                                <span class="pull-right" id="card-cost" data-card-cost="{{ config('constant.card_cost') }}">฿{{ config('constant.card_cost') }}</span></p>
                            <p>
                                <b>รวมสุทธิ
                                    <span class="pull-right">฿
                                        <span id="total" data-transport-cost="0" data-card-cost="0" data-order-total="{{ $order['total'] }}">{{ $order['total'] }}</span>
                                    </span>
                                </b>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="box customer-service">
                <h4>ต้องการความช่วยเหลือ?</h4>
                ติดต่อเราได้ทุกวัน ตั้งแต่ 9:00-18:00 น.
                <p>โทร. {{ config('profile.phone-primary') }}</p>
                <p>Facebook&nbsp;:&nbsp;<a href="{{ config('profile.facebook') }}">MubazaThailand</a></p>
                <p>Line ID&nbsp;:&nbsp;<b>{{ config('profile.sitename') }}</b></p>
                <p>Line QR Code&nbsp;:&nbsp;</p>
                <p><img width="60%" src="{{asset('images/mubazaQR.png')}}"></p>
            </div>
        </div>
        <div class="col-md-8 col-xs-12">
            <div id="step2" class="box">
                <div class="box-title font-title">
                    การชำระเงิน
                </div>
                <div class="description"></div>
                <div class="content">
                    <div id="tabs">
                        <form class="payment_type_form" id="payment-type-form" method="post" action="#">
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
                        </form>
                    </div>
                </div>
                <div class="footer">
                    <a href="javascript:void(0)" id="btn-submit" class="btn btn-success btn-medium"><i
                                class="fa fa-check"></i>&nbsp;ดำเนินการต่อ</a>
                </div>
            </div>
        </div>
        

    </div>
@stop
