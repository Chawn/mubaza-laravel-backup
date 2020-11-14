@extends('layouts.full_width')
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

        #page-informpayment {
            margin-top: 35px;
        }

        .form-group {
            padding-right: 30px;
        }

        #informpayment-box {
            padding: 0px 0px 0 0;
        }

        .col-sm-3 {
            padding-right: 0px;

        }

        .box {
            background: #fff;
            border: solid 1px #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .customer-service {
            padding: 20px 30px;
        }

        label {
            font-size: 16px;
            font-weight: normal;
            text-align: right;
            vertical-align: middle;
            vertical-align: bottom;
            padding-top: 5px;
        }

        .card-img {
            width: 50px;
            height: 30px;
            margin-right: 10px;
        }

        .choose {
            border: 1px solid #e67e22;
        }

        .footer {
            width: 100%;
            padding: 15px 30px;
            text-align: right;
            border-top: solid 1px #ddd;
        }

        .gray {
            background: #eee;
        }

        .totol-label {
            margin-left: 10px;
            float: left;
            font-size: 22px;
            color: #555;
        }

        .total-no {
            margin-right: 10px;
            float: right;
            font-weight: bold;
        }

        .total-no span {
            font-weight: normal;
            font-size: 20px;
        }

        .basket-total {
            background: #fff;
        }

        @media (max-width: 480px) {
            .mobile-hidden {
                display: none;
            }

            .box {
                margin: 5px;
            }

            .margin-mobile {
                margin-bottom: 15px;
            }

            .col-sm-9 {
                padding-right: 0px;
            }

            .basket-total {
                padding: 0 10px;
            }
        }
    </style>
@stop

@section("script")
    <script src="https://cdn.omise.co/omise.js"></script>
    <script>
        Omise.setPublicKey('{{ env('OMISE_PUBLIC_KEY') }}');
        $(document).ready(function () {
            $("#checkout-form").submit(function () {

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
                        form.get(0).submit();
                    }
                });

                // Prevent the form from being submitted;
                return false;

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".a-card").click(function () {
                $(".a-card.choose").removeClass("choose");
                $(this).addClass("choose");

            });
        });
    </script>
@stop
@section('content')
    <div class="container">
        @include('backend.layouts.include.alert')
    </div>
    <div id="checkout">
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-title font-title">
                        ชำระเงินผ่านบัตรเครดิต/เดบิต
                    </div>
                    <div class="content">
                        <form class="form-horizontal" id="checkout-form"
                              action="{{ Request::is('sell/order-success/*') ? action('SellController@postSaveCard') : action('OrderController@postChargeCard') }}"
                              method="post">
                            <div id="informpayment-box" class="">

                                <div class="alert alert-danger hidden" id="token_errors"></div>

                                <input type="hidden" name="omise_token" class="form-control">
                                <input name="order_id" type="hidden" value="{{ $order->id }}" }}/>
                                <input name="finanacing" type="hidden"/>

                                <div class="form-group">
                                    <label for="card-type" class="col-sm-3 control-label mobile-hidden"></label>

                                    <div class="col-sm-9">
                                        <img class="card-img" src="{{ asset('images/icon/visa.png') }}">
                                        <img class="card-img" src="{{ asset('images/icon/mastercard.png') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="holder_name"
                                           class="col-sm-3 control-label mobile-hidden">ชื่อผู้ถือบัตร:</label>

                                    <div class="col-sm-9">
                                        <input type="text" placeholder="ชื่อผู้ถือบัตร"
                                               data-omise="holder_name" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="number" class="col-sm-3 control-label mobile-hidden">หมายเลขบัตร:</label>

                                    <div class="col-sm-9">
                                        <input type="text" placeholder="หมายเลขบัตร"
                                               data-omise="number" class="form-control" min="16">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="expiration"
                                           class="col-sm-3 control-label mobile-hidden">วันหมดอายุ:</label>

                                    <div class="col-sm-3 margin-mobile">
                                        <input type="text" data-omise="expiration_month" size="8" placeholder="เดือน"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" data-omise="expiration_year" size="8" placeholder="ปี"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="security_code" class="col-sm-3 control-label mobile-hidden">รหัสความปลอดภัย:</label>

                                    <div class="col-sm-3">
                                        <input type="text" placeholder="รหัสความปลอดภัย"
                                               data-omise="security_code" size="8" class="form-control">
                                    </div>
                                </div>

                                <div class="footer">
                                    <input type="submit" class="btn btn-success btn-medium" id="create_token"
                                           value="ยืนยันการชำระเงิน">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="total" class="col-md-4">
                <div id="overall" class="box">
                    <div class="box-title font-title">
                        <i class="fa fa-shopping-cart"></i>
                        สินค้าที่สั่งซื้อ
                    </div>
                    <div class="content">
                        <div class="basket-total">
                            <p>หมายเลขสั่งซื้อ : {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>

                            <p><b>รวมสุทธิ<span class="pull-right">฿<span
                                                id="total">{{ $order->subTotal() }}</span></span></b>
                            </p></div>
                    </div>
                </div>
                <div class="box customer-service">
                    <h4>ต้องการความช่วยเหลือ?</h4>
                    ติดต่อเราได้ทุกวัน ตั้งแต่ 8:00-18:00 น.
                    <br>โทร. 089-728-1028, 02-240-0000
                </div>
            </div>
        </div>
    </div>
@stop