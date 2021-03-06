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
@section('script')
    <script>

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }

    </script>

@stop
@section('progress-step')
    @include('layouts.include.checkout-progress') 
@stop
@section('content')
    {{--<div class="row">--}}
        {{--<div class="col-sm-12">--}}
            {{--<h2 class="text-center">--}}
                {{--เกือบเสร็จแล้ว..--}}
            {{--</h2>--}}
            {{--<p class="text-center">--}}
                {{--การสั่งซื้อจะเสร็จสมบูรณ์ เมื่อคุณโอนเงินและแจ้งชำระเงินแล้ว--}}
            {{--</p>--}}
            {{--<div class="row row-image text-center">--}}
                {{--<div class="column">--}}
                    {{--<img class="atm" src="{{ asset('images/icon/atm.png') }}">--}}

                    {{--<p>1. โอนเงิน</p>--}}
                {{--</div>--}}
                {{--<div class="column">--}}
                    {{--<img class="arrow-right" src="{{ asset('images/icon/arrow-right.png') }}">--}}
                {{--</div>--}}
                {{--<div class="column">--}}

                    {{--<img class="confirm" src="{{ asset('images/icon/confirm-payment.png') }}">--}}

                    {{--<p>2. แจ้งชำระเงิน</p>--}}

                {{--</div>--}}
            {{--</div>--}}
            <div id="view-user-order">
                <h3>รายการสั่งซื้อ #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h3>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                                <td class="col-md-6">
                                    <p><b>วันที่สั่งซื้อ</b> {{ $order->created_at->format('d/m/Y') }}</p>
                                </td>
                                <td>
                                    <p><b>สถานะการชำระเงิน</b> <span class="text-red">{{ $order->payment_status->detail }}</span>
                                    </p>
                                    {{--<p><b>วิธีชำระเงิน</b> {{ $order->payment_type->detail }}--}}
                                    {{--</p>--}}

                                </td>
                            </tr>
                            <tr class="no-print">
                                <td>
                                    <p><b>ที่อยู่สำหรับจัดส่ง</b></p>

                                    <p>{!! $order->getFullAddress() !!}</p>
                                </td>
                                <td>
                                    <p><b>วิธีการจัดส่ง</b>

                                    <p>{{ $order->shipping_type->detail }}</p>
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
                                        @foreach($order->items as $item)
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
                                                <span>฿</span>{{ $order->shipping_cost }}<span>&nbsp;THB</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right">รวมสุทธิ:</td>
                                            <td>
                                                <span>฿</span>{{ number_format($order->subTotal()) }}<span>&nbsp;THB</span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <h3>บัญชีธนาคารสำหรับโอนเงิน</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>ธนาคาร</th>
                        <th>สาขา</th>
                        <th>เลขบัญชี</th>
                        <th>ชื่อบัญชี</th>
                    </tr>
                    <tr>
                        <td><img class="bank-icon" src="{{ asset('images/icon/bangkok-bank.jpg') }}" alt="">กรุงเทพ</td>
                        <td>เซ็นทรัลพลาซา อุดรธานี</td>
                        <td>616-7-13274-2</td>
                        <td>ร้าน มูบาซ่า</td>
                    </tr>
                    <tr>
                        <td><img class="bank-icon" src="{{ asset('images/icon/kasikorn-bank.jpg') }}" alt="">กสิกรไทย
                        </td>
                        <td>เซ็นทรัลพลาซา อุดรธานี</td>
                        <td>512-2-51660-3</td>
                        <td>ร้าน มูบาซ่า</td>
                    </tr>
                    <tr>
                        <td><img class="bank-icon" src="{{ asset('images/icon/ktb.jpg') }}" alt="">กรุงไทย</td>
                        <td>เซ็นทรัลพลาซา อุดรธานี</td>
                        <td>443-0-59537-2</td>
                        <td>มูบาซ่า โดย นายชาวพุทธ นวกาลัญญู</td>
                    </tr>
                    <tr>
                        <td><img class="bank-icon" src="{{ asset('images/icon/logo-tmb.png') }}" alt="">ทหารไทย</td>
                        <td>ถนนโพศรี อุดรธานี</td>
                        <td>465-2-23726-6</td>
                        <td>มูบาซ่า โดย นายชาวพุทธ นวกาลัญญู</td>
                    </tr>
                </table>
            </div>
            <div class="text-center no-print">
                {{--@if($order->payment_type->name == 'transfer')--}}
                {{--<a href="{{ action('OrderController@getUpdatePayment', $order->id) }}" class="btn btn-success btn-lg">แจ้งชำระเงิน--}}
                {{--</a>--}}
                {{--&nbsp;--}}
                {{--<button class="btn btn-default btn-lg" id="confim-cancel-order"--}}
                        {{--data-toggle="modal" data-target="#modal-cancel-order">ยกเลิกการสั่งซื้อ--}}
                {{--</button>--}}
                {{--&nbsp;--}}
                {{--@endif--}}
                <button onclick="printDiv('view-user-order')" id="print_button" class="btn btn-primary btn-lg">พิมพ์หน้านี้
                </button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-cancel-order">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ยกเลิกการสั่งซื้อ</h4>
                </div>
                <div class="modal-body">
                    ต้องการยกเลิกการสั่งซื้อเลขที่ : {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} ไช่หรือไม่
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <a href="{{ action('OrderController@getCancelOrder', $order->id) }}"
                       class="btn btn-success">ยืนยัน</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <br><br>



@stop