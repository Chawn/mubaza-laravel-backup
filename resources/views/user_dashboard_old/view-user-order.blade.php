@extends('layouts.user_full_width')
@section('css')
    <style type="text/css">
        #view-user-order {

            max-width: 700px;
            margin: 15px auto;
            background: #fff;

            border-radius: 5px;

        }
        #user-order {
            margin-bottom: 50px;

        }
        #user-order .wrapper{
            padding-bottom: 25px;
        }
        #campaign-img {
            text-align: center;

        }
        #campaign-img img {
            max-width: 45%;
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
        #box-btn{
            padding: 20px 0;
            text-align: right;
        }
        @media (max-width: 480px){
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
            #box-btn{
                padding: 20px 0;
                text-align: center;
            }
        }/*media*/
        @media print {
            #campaign-img img {
                width: 100px;
            }
            .no-print{
                display: none;
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
@section('content')
    <div id="view-user-order">
        <h2>รายการสั่งซื้อ #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h2>
        <div class="row">
            <div class="col-md-7">

                <p>วันที่สั่งซื้อ {{ $order->created_at }}</p>
            </div>
            <div class="col-md-5">
{{--                <p><b>แคมเปญสิ้นสุด:</b> {{ $order->campaign->end->format('d/m/Y') }}</p>--}}
                <p><b>สถานะแคมเปญ:</b> {{ $order->status->detail }}</p>
                {{--@if($order->campaign->status->name == 'cancel' && $order->campaign->status->name == 'ban')--}}
                    {{--<p><b>สถานะการคืนเงิน:</b> {{ $order->payoutStatus() }}</p>--}}
                    {{--<p><b>ชื่อบัญชี:</b> {{ $order->payout->first()->name }}</p>--}}
                    {{--<p><b>ชื่อธนาคาร:</b> {{ $order->payout->first()->bank_name }}</p>--}}
                    {{--<p><b>เลขที่บัญชี:</b> {{ $order->payout->first()->no }}</p>--}}
                {{--@endif--}}
                @if($order->status->name == \App\OrderStatus::SHIPPED)
                    <p>
                        หมายเลขการจัดส่ง:
                        {{ is_null($order->shipping_address->tracking_no) ? '' : $order->shipping_address->tracking_no }}
                    </p>
                @endif
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-7">
                <p><b>รายละเอียดการชำระเงิน</b></p>
                <p>{{ $order->payment_status->detail }}</p>
            </div>
            <div class="col-md-5">
                <p><b>วิธีชำระเงิน</b>
                <p>{{ $order->payment_type->detail }}</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-7">
                <p><b>ที่อยู่สำหรับจัดส่ง</b></p>
                <p>{!! $order->getFullAddress() !!}</p>
            </div>
            <div class="col-md-5">
                <p><b>วิธีการจัดส่ง</b>
                <p>{{ $order->shipping_type->detail }}</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <p><b>รายละเอียดการสั่งซื้อ</b></p>
                <div class="row">
                    {{--<div class="col-md-4">--}}
                        {{--<div id="campaign-img">--}}
                            {{--<img id="campaign-img-font" src="{{ $order->campaign->design->image_front_preview }}">--}}
                            {{--<img id="campaign-img-back" src="{{ $order->campaign->design->image_back_preview }}">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="col-md-12">
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
                                    <td>{{ $item->campaign_product->campaign->title }}</td>
                                    <td>
                                        {{ $item->sku->color->product->name }}&nbsp;{{ $item->sku->color->color_name }}&nbsp;ขนาด&nbsp;{{ $item->sku->size }}
                                    </td>
                                    <td>
                                        {{ $item->qty }}
                                    </td>
                                    <td>
                                        <span>฿</span>{{ $item->price * $item->qty }}<span>&nbsp;THB</span>
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
                                    <span>฿</span>{{ number_format($order->sub_total) }}<span>&nbsp;THB</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row no-print">
            <div class="col-md-12">
                <div class="text-center">
                    @if($order->payment_status->name == 'waiting')
                        <a href="{{ url('order/payment') }}" class="btn btn-success btn-lg">แจ้งชำระเงิน</a>
                        <button class="btn btn-danger btn-lg" id="confim-cancel-order"
                                data-toggle="modal" data-target="#modal-cancel-order">ยกเลิกการสั่งซื้อ</button>
                    @endif
                    <button  onclick="printDiv('view-user-order')" id="print_button" class="btn btn-default btn-lg">พิมพ์</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-cancel-order">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ยกเลิกการสั่งซื้อ</h4>
                </div>
                <div class="modal-body">
                    ต้องการยกเลิกการสั่งซื้อเลขที่ : {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} ไช่หรือไม่
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <a href="{{ action('OrderController@getCancelOrder', $order->id) }}" class="btn btn-success">ยืนยัน</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop