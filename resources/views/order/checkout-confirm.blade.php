@extends('layouts.full_width')
@section('css')
    <style type="text/css">
        .column {
            vertical-align: middle;
        }

        img.arrow-right {
            width: 50px;
            opacity: 0.3;
            margin: 0 20px;
        }

        img.atm, img.confirm {
            margin: 0px 5px 5px 10px;
            height: 100px;
        }

        img.arrow {
            width: 15px;
        }

        .row-image {
            padding: 25px 0 15px 0;
        }

        .bank-icon {
            width: 40px;
            margin-right: 5px;
        }

        #view-user-order {
            max-width: 860px;
            padding: 40px 50px;
            box-shadow: 0 0 10px #aaa;

            margin: 15px auto;
            background: #fff;

        }

        #user-order {
            margin-bottom: 50px;

        }

        #user-order .wrapper {
            padding-bottom: 25px;
        }

        #campaign-img {
            text-align: center;

        }

        .product-image {
            max-width: 25%;
        }

        #group-flip-btn {
            text-align: center;
            margin-top: 15px;
        }

        .btn-flip {
            width: 30px;
            height: 30px;
            border-radius: 50px;
            text-align: center;
            vertical-align: middle;
            padding-top: 7px;
            padding-left: 5px;
            border: 1px solid #979797;
            color: #202020;
            font-size: 5px;
        }

        .btn-flip:hover {
            border: 1px solid #8a8a8a;
            color: #202020;
            background: #f5f5f5;
        }

        .blue {
            border: 1px solid #2c4257;
            background: #36465d;
            color: #fff;
        }

        .blue:hover {
            color: #eee;
            background: #2c4257;
            border: 1px solid #2c4257;
        }

        .blue:focus {
            color: #eee;
            background: #2c4257;
        }

        .btn-shadow {
            box-shadow: 2px 2px 3px #aaa;
        }

        #btn-flip-font {
            margin-right: 10px;
        }

        .sub-detail {
            border-top: 1px solid #ddd;
        }

        .right-detail {
            vertical-align: middle;
            padding-top: 7px;
            padding-left: 0px;
        }

        .none-margin-bottom {
            margin-bottom: 0px;
        }

        .none-padding-bottom {
            padding-bottom: 0px;
        }

        .total {
            font-size: 18px;
            font-weight: normal;
            text-align: right;
            padding-top: 3px;
        }

        .price-total {
            font-size: 20px;
            display: inline;
            padding-left: 0px;
        }

        .price-total span {
            font-size: 14px;
        }

        .control-label {
            font-weight: normal;
            color: #555;
        }

        #box-btn {
            padding: 20px 0;
            text-align: right;
        }

        @media (max-width: 480px) {
            #user-mobile-menu,
            #user-header {
                display: none;
            }

            .btn-back {
                width: 100%;
                border-radius: 0px;
            }

            #campaign-img {
                margin-top: 15px;
            }

            #campaign-img img {
                width: 45%;
            }

            .sub-detail {
                padding-top: 10px;
                font-size: 12px;
            }

            .right-detail {
                padding-top: 0px;
            }

            .control-label {
                text-align: right;
            }

            .mobile-form-group {
                padding-right: 15px;
            }

            #box-btn {
                padding: 20px 0;
                text-align: center;
            }
        }

        /*media*/
        @media print {
            #campaign-img img {
                width: 100px;
            }

            .no-print {
                display: none;
            }

            hr {
                margin: 5px 0;
            }

            a[href]:after {
                content: "" !important;
            }
        }

        /*col 2*/
    </style>
@stop
@section('progress-step')
    @include('layouts.include.checkout-progress')
@stop
@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h2 class="text-center">
                    ยืนยันการสั่งซื้อ
                </h2>
                <p class="text-center">
                    ตรวจสอบข้อมูลการสั่งซื้อเพื่อความถูกต้อง
                </p>
                <div id="view-user-order">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <td>&nbsp;</td>
                                    <td class="col-md-6" align="right">
                                        <p><b>วันที่สั่งซื้อ</b> {{ \Carbon::now()->format('d/m/Y') }}</p>
                                    </td>
                                </tr>
                                <tr class="no-print">
                                    <td>
                                        <p><b>ที่อยู่สำหรับจัดส่ง</b></p>

                                        <p>{{ $order['shipping_data']['full_name'] }}
                                            <br>{{ $order['shipping_data']['address'] }}
                                            @if ( isset($order['shipping_data']['building']) )
                                                <br> อาคาร {{ $order['shipping_data']['building'] }}
                                            @endif
                                            <br> อำเภอ {{ $order['shipping_data']['district'] }}
                                            <br> จังหวัด {{ $order['shipping_data'] ['province'] }}
                                            <br> {{ $order['shipping_data']['zipcode'] }}</p>
                                    </td>
                                    <td>
                                        <p><b>วิธีการจัดส่ง</b>

                                        <p>{{ \App\ShippingType::getDetail($order['shipping_type_id']) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p><b>รายละเอียดการสั่งซื้อ</b></p>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>ชื่อแคมเปญ</th>
                                                <th>สินค้า</th>
                                                <th>จำนวน</th>
                                                <th>ราคา</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($cart->items as $item)
                                                <tr>
                                                    <td>
                                                        <a href="{{ action('CampaignController@showCampaign', $item->campaign->url) }}">{{ $item->campaign->title }}</a>
                                                    </td>
                                                    <td>
                                                        {{ $item->sku->color->product->name }}
                                                        &nbsp;{{ $item->sku->color->color_name }}
                                                        &nbsp;ขนาด&nbsp;{{ $item->sku->size }}
                                                    </td>
                                                    <td>
                                                        {{ $item->qty }}
                                                    </td>
                                                    <td>
                                                        <span>฿</span>{{ $item->total() }}<span>&nbsp;THB</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3" class="text-right">ค่าจัดส่ง:</td>
                                                <td>
                                                    <span>฿</span>{{ $order['shipping_cost'] }}<span>&nbsp;THB</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-right">รวมสุทธิ:</td>
                                                <td>
                                                    <span>฿</span>{{ number_format(intVal($order['shipping_cost']) + $cart->total()) }}<span>&nbsp;THB</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="text-center no-print">
                    <a href="{{ action('OrderController@getCheckout', $cart->session_id) }}"
                       class="btn btn-default"><i class="fa fa-pencil"></i>&nbsp;แก้ไขข้อมูล</a>
                    <a href="{{ action('OrderController@getConfirmOrder', $cart->session_id) }}" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;ยืนยันการสั่งซื้อ</a>
                </div>
            </div>
        </div>
@stop