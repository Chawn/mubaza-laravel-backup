@extends('user.layouts.order-detail')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/order-tracking.css') }}">
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

        #user-order .wrapper {
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

        #box-btn {
            padding: 20px 0;
            text-align: right;
        }

        @media (max-width: 767px) {
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
            .no-print .btn{
                display: block;
                width: 100%;
                margin-bottom: 8px;
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
<div class="panel" >
    <div class="panel-heading">
        {{ $title }}
    </div>
    <div class="panel-body">
        <div id="view-user-order">
        <div class="order-step">
            <div class="step step1 {{ $order->payment_status->name == 'paid' ? 'pass':'' }} text-center">
                <p>ชำระเงินแล้ว</p>
                <div class="circle">
                    <i class="fa fa-2x fa-money"></i>
                </div>
            </div>
            <div class="step step1 {{ $order->produce_status->name == 'producing' ||
                                          $order->produce_status->name == 'produced' ||
                                          $order->produce_status->name == 'shipping' || $order->produce_status->name == 'shipped' ? 'pass': ''}}"></div>
            <div class="step step2 {{ $order->produce_status->name == 'producing' ||
                                          $order->produce_status->name == 'produced' ||
                                          $order->produce_status->name == 'shipping' || $order->produce_status->name == 'shipped' ? 'pass': ''}} text-center">
                <p>ดำเนินการผลิต</p>
                <div class="circle">
                    <i class="fa fa-2x fa-archive"></i>
                </div>
            </div>
            <div class="step {{ $order->produce_status->name == 'shipped' ? 'pass' : '' }} step2"></div>
            <div class="step {{ $order->produce_status->name == 'shipped' ? 'pass' : '' }} text-center">
                <p>จัดส่งแล้ว</p>
                <div class="circle">
                    <i class="fa fa-2x fa-truck flip-horizontal"></i>
                </div>
            </div>
        </div>
                <div class="row">
                    
                    <div class="col-md-7">
                        {{--                <p><b>แคมเปญสิ้นสุด:</b> {{ $order->campaign->end->format('d/m/Y') }}</p>--}}
                        <p>
                            <b>สถานะการสั่งซื้อ:</b> 
                            
                            @if($order->produce_status->name=='shipped')
                                <span class="text-success">
                                    <i class="fa fa-check"></i>
                            @else
                                <span class="text-danger">
                            @endif
                                    {{ $order->produce_status->detail }}
                                </span>
                        </p>
                        <p>
                            <b>สถานะการชำระเงิน:</b> 
                            @if($order->payment_status->name=='paid')
                                <span class="text-success">
                                    <i class="fa fa-check"></i>
                            @else
                                <span class="text-danger">
                            @endif
                            {{ $order->payment_status->detail }}
                            </span>
                        </p>
                        <p>
                            <b>ช่องทางชำระเงิน:</b>
                            {{ $order->payment_type->detail }}
                        </p>
                        {{--@if($order->campaign->status->name == 'cancel' && $order->campaign->status->name == 'ban')--}}
                        {{--<p><b>สถานะการคืนเงิน:</b> {{ $order->payoutStatus() }}</p>--}}
                        {{--<p><b>ชื่อบัญชี:</b> {{ $order->payout->first()->name }}</p>--}}
                        {{--<p><b>ชื่อธนาคาร:</b> {{ $order->payout->first()->bank_name }}</p>--}}
                        {{--<p><b>เลขที่บัญชี:</b> {{ $order->payout->first()->no }}</p>--}}
                        {{--@endif--}}
                        @if($order->produce_status->name == 'shipped')
                            <p>
                                <strong>หมายเลขการจัดส่ง:</strong>
                                {{ is_null($order->shipping_address->tracking_code) ? '' : $order->shipping_address->tracking_code }}
                            </p>
                        @endif
                    </div>
                    <div class="col-md-5">
                        <p><strong>รหัสสั่งซื้อ: </strong> #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                        <p><strong>วันที่สั่งซื้อ: </strong> {{ $order->created_at }}</p>
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
                        <p><b>สินค้า</b></p>
                        <div class="row">
                            {{--<div class="col-md-4">--}}
                            {{--<div id="campaign-img">--}}
                            {{--<img id="campaign-img-font" src="{{ $order->campaign->design->image_front_preview }}">--}}
                            {{--<img id="campaign-img-back" src="{{ $order->campaign->design->image_back_preview }}">--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            <div class="col-md-12">
                                <table class="table table-bordered table-flex">
                                    <thead>
                                    <tr>
                                        <th>ชื่อสินค้า</th>
                                        <th>สินค้า</th>
                                        <th>จำนวน</th>
                                        <th>ราคา</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td data-label="ชื่อสินค้า">{{ $item->campaign_product->campaign->title }}</td>
                                            <td data-label="สินค้า">
                                                {{ $item->sku->color->product->name }}&nbsp;{{ $item->sku->color->color_name }}
                                                &nbsp;ขนาด&nbsp;{{ $item->sku->size }}
                                            </td>
                                            <td data-label="จำนวน">
                                                {{ $item->qty }}
                                            </td>
                                            <td data-label="ราคา">
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
                
                <div class="row no-print">
                    <div class="col-md-12">
                        <div class="text-center">
                            @if($order->payment_status->name == 'waiting')
                                <a href="{{ action('OrderController@getUpdatePayment', $order->id) }}" class="btn btn-success btn-lg">แจ้งชำระเงิน</a>
                                <button class="btn btn-danger btn-lg" id="confim-cancel-order"
                                        data-toggle="modal" data-target="#modal-cancel-order">ยกเลิกการสั่งซื้อ
                                </button>
                            @endif
                            {{-- <button onclick="printDiv('view-user-order')" id="print_button" class="btn btn-default btn-lg">
                                พิมพ์
                            </button> --}}

                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

<div class="panel">
    <div class="panel-heading">
        ติดตามสถานะการสั่งซื้อ
    </div>
    <div class="panel-body">
        
        <table width="100%" class="">
            <thead>
                <tr>
                    <th width="20%">
                        วันที่
                    </th>
                    <th>
                        รายละเอียด
                    </th>

                </tr>
            </thead>
            <tbody>
            @foreach($order->trackings as $tracking)
                <tr>
                    <td>
                        {{ $tracking->created_at->format('j/m/Y H:i') }}
                    </td>
                    <td>
                        {{ $tracking->type->detail }}
                        @if($tracking->type->name == 'shipped')
                            รหัสเพื่อติดตามการจัดส่ง {{ $tracking->detail }}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
            @if($order->produce_status->name == 'shipped')
                {{-- <tfoot>
                <tr>
                    <td colspan="2"><a href="{{ action('OrderController@getCustomerReceived', $order->id) }}" class="btn btn-block btn-lg btn-success">ได้รับสินค้าแล้ว</a>
                    </td>
                </tr>
                </tfoot> --}}
            @endif
        </table>
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
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop