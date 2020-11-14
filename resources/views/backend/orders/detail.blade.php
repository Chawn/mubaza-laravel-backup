@extends('backend.layouts.master')
<link rel="stylesheet" href="{{ asset('css/new-backend.css') }}">
@section('css')
    <link rel="stylesheet" href="{{ asset('datetimepicker-master/jquery.datetimepicker.css') }}"/>
    <style>

        #table-manufacture-detail h3 {
            display: inline;
        }

        #table-manufacture-detail h2 {
            font-size: 14px;
            color: #666;
        }

        #table-manufacture-detail > tbody > tr > td:nth-child(2) {
            text-align: left;
        }

        .product-item img {
            width: 150px;
        }

        .art-image {
            width: 100px;
        }

        .small-product-image {
            width: 80px;
        }
        

        .box.order-detail{
            z-index: 1;
        }
        /*progressbar*/
        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            /*CSS counters to number the steps*/
            counter-reset: step;
            padding: 0;
        }
        #progressbar li {
            list-style-type: none;
            text-transform: uppercase;
            font-size: 12px;
            width: 20%;
            float: left;
            position: relative;
        }
        #progressbar li>i {
            /*content: counter(step);
            counter-increment: step;*/
            width: 24px;
            line-height: 24px;
            display: block;
            font-size: 10px;
            color: #333;
            background: #ddd;
            border-radius: 3px;
            margin: 0 auto 5px auto;
        }
        /*progressbar connectors*/
        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: #ddd;
            position: absolute;
            left: -50%;
            top: 9px;
            z-index: -1; /*put it behind the numbers*/
        }
        #progressbar li:first-child:after {
            /*connector not needed before the first step*/
            content: none; 
        }
        /*marking active/completed steps green*/
        /*The number of the step and the connector before it = green*/
        #progressbar li.active>i{
            background: #27AE60;
            color: white;
        }
        #progressbar li.active{
            color: #27AE60;
        }

        #msform {
            width: 100%;
            margin: 50px auto;
            text-align: center;
            position: relative;
        }
    </style>
@stop
@section('script')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"> </script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"> </script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"> </script>
    <script src="{{ asset('datetimepicker-master/jquery.datetimepicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            jQuery('#transferred_on').datetimepicker({
                format: 'd/m/Y H:i',
                step: 1,
                inline: false,
                lang: 'th'
            });

            $('#payment-form').validate({
                errorPlacement: function (error, element) {
                    // Append error within linked label
                    $(element).addClass('error');
                }
            });

            $('#save-btn').click(function() {
                if($('#payment-form').valid())
                {
                    $('#payment-form').submit();
                }
            });
        });
    </script>
@stop
@section('content')
    <div class="container">
        @include('backend.layouts.include.alert')
    </div>
    <div class="row">
        <div class="col-sm-9">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box order-detail" >
                        <div class="box-header">
                            {{ $title }}
                        </div>
                        <div class="box-body">
                            <form action="" id="msform">
                                <ul id="progressbar">
                                    <li class="{{ ($step>=1) ? 'active' : '' }}">
                                        <i class="fa fa-bell-o"></i> แจ้งชำระเงิน
                                    </li>
                                    <li class="{{ ($step>=2) ? 'active' : '' }}">
                                        <i class="fa fa-money"></i> ชำระเงินแล้ว
                                    </li>
                                    <li class="{{ ($step>=3) ? 'active' : '' }}">
                                        <i class="glyphicon glyphicon-hourglass"></i> กำลังผลิต
                                    </li>
                                    <li class="{{ ($step>=4) ? 'active' : '' }}">
                                        <i class="fa fa-cubes"></i> รอจัดส่ง
                                    </li>
                                    <li class="{{ ($step>=5) ? 'active' : '' }}">
                                        <i class="fa fa-truck"></i> จัดส่งแล้ว
                                    </li>
                                </ul>
                            </form>
                            <div id="view-user-order">
                                <div class="row">
                                    
                                    <div class="col-md-7">
                                        {{--                <p><b>แคมเปญสิ้นสุด:</b> {{ $order->campaign->end->format('d/m/Y') }}</p>--}}
                                        <p>
                                            <b>สถานะการสั่งซื้อ:</b>

                                            @if($order->status->name== \App\OrderStatus::SHIPPED)
                                                <span class="text-success">
                                                    <i class="fa fa-check"></i>
                                            @else
                                                <span class="text-danger">
                                            @endif
                                                    {{ $order->status->detail }} : {{ $order->remark }}
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
                                        @if($order->status->name == \App\OrderStatus::SHIPPED)
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
                                                            <td data-label="ชื่อสินค้า">
                                                                <a href="{{ action('BackendController@getCampaignDetail', $item->campaign_product->campaign->id) }}">
                                                                    <img class="small-product-image" src="{{ action('CampaignController@getFile', [$item->campaign->id, $item->campaign->frontCover('image_front_small')]) }}">
                                                                    {{ $item->campaign_product->campaign->title }}
                                                                </a>
                                                            </td>
                                                            <td data-label="สินค้า">
                                                                {{ $item->sku->color->product->name }}&nbsp;{{ $item->sku->color->color_name }}
                                                                &nbsp;ขนาด&nbsp;{{ $item->sku->size }}
                                                                <p>SKU: {{ $item->sku->id }}</p>
                                                            </td>
                                                            <td data-label="จำนวน">
                                                                {{ $item->qty }}
                                                            </td>
                                                            <td data-label="ราคา">
                                                                <span>฿</span>{{ $item->price * $item->qty }}<span>&nbsp;THB</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        
                                                        <tr>
                                                            <td colspan="3" class="text-right">ยอดสั่งซื้อ:</td>
                                                            <td>฿{{ number_format($order->totalExcludeShippingCost(), 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="text-right">ส่วนลด:</td>
                                                            <td>
                                                                <span>฿</span>{{ $order->coupon_discount_total }}<span>&nbsp;THB</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="text-right">ภาษี (0%)</td>
                                                            <td>0</td>
                                                        </tr>
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
                                                    </tfoot>
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

                    <div class="box">
                        <div class="box-header">
                            ติดตามสถานะการสั่งซื้อ
                        </div>
                        <div class="box-body">
                            
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
                                @if($order->status->name == \App\OrderStatus::SHIPPED)
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
                    <div class="box">
                        <div class="box-header">
                            รายละเอียดการแจ้งชำระเงิน
                        </div>
                        <div class="box-body">
                            
                            <h3 class="text-danger">{{ $order->payment_status->detail }}</h3>
                            @if($order->payment_status->name != 'waiting' && $order->payment_status->name != 'cancel')
                            <br>โอนเข้าธนาคาร: {{ $order->payment()->first()->to_bank }}
                            <br>วันที่: {{ $order->payment()->first()->pay_on->format('d/m/Y') }}
                            <br>เวลา: {{ $order->payment()->first()->pay_on->format('H:i') }} น.
                                <br>จำนวนเงิน: {{ number_format($order->payment()->first()->total, 2) }}
                            @endif

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
                </div>
                <!-- /.col -->
            </div>
            
        </div>
        <div class="col-sm-3">
            <div class="box">
                <div class="box-header">เครื่องมือ</div>
                <div class="box-body">
                    @if($order->payment_type->name == 'transfer')
                        @if($order->payment_status->name == 'waiting')
                            <button class="btn btn-primary btn-block"
                                    data-toggle="modal" data-target="#payment-save-modal">
                                <i class="fa fa-credit-card"></i> แจ้งชำระเงิน
                            </button>
                            <button class="btn btn-danger btn-block"
                                    data-toggle="modal" data-target="#modal-cancel-payment">
                                <i class="fa fa-times"></i> ไม่อนุมัติ
                            </button>
                        @elseif($order->payment_status->name == 'approve')
                            <button class="btn btn-success btn-block"
                                    data-toggle="modal" data-target="#modal-confirm-payment">
                                <i class="fa fa-credit-card"></i> อนุมัติ
                            </button>
                        @elseif($order->payment_status->name == 'paid')
                            @if($order->status->name != \App\OrderStatus::CANCEL)
                            <button class="btn btn-warning btn-block"
                                    data-toggle="modal" data-target="#modal-reset-payment">
                                <i class="fa fa-credit-card"></i> รอตรวจสอบอีกครั้ง
                            </button>
                            @endif
                            <button class="btn btn-danger btn-block" data-toggle="modal"
                                    data-target="#modal-return-order"><i class="fa fa-times"></i>
                                {{ $order->return_order ? 'แก้ไขข้อมูลการยกเลิกสั่งซื้อและคืนเงิน' : 'ยกเลิกการสั่งซื้อและคืนเงิน' }}
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>


@if($order->payment_status->name == 'approve')
    <div class="modal fade" id="modal-confirm-payment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ยืนยันการชำระเงิน</h4>
                </div>
                <div class="modal-body">
                    ต้องการยืนยันการชำระเงินรหัสสั่งซื้อ : {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} ยอดชำระ {{ $order->payment()->first()->total }} บาท หรือไม่
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <a href="{{ action('BackendController@getConfirmPayment', $order->id) }}" class="btn btn-success">ยืนยัน</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@elseif($order->payment_status->name == 'waiting')
    <div class="modal fade" id="modal-cancel-payment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ยกเลิกการชำระเงิน</h4>
                </div>
                <div class="modal-body">
                    ต้องการยกเลิกการชำระเงินรหัสสั่งซื้อ : {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}  หรือไม่
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <a href="{{ action('BackendController@getCancelPayment', $order->id) }}" class="btn btn-success">ยืนยัน</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @elseif($order->payment_status->name == 'paid')
    <div class="modal fade" id="modal-reset-payment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ตรวจสอบการชำระเงินอีกครั้ง</h4>
                </div>
                <div class="modal-body">
                    ตรวจสอบการชำระเงินรหัสสั่งซื้อ : {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} ยอดชำระ {{ $order->payment->total }} บาท หรือไม่
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <a href="{{ action('BackendController@getResetUpdatePayment', $order->id) }}" class="btn btn-success">ยืนยัน</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @endif
    <div class="modal fade" id="payment-save-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">แจ้งการชำระเงิน</h4>
                </div>
                <div class="modal-body">
                    <form id="payment-form" method="POST" action="{{ action('BackendController@postUpdatePayment', $order->id) }}">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                        <input name="order_id" id="order-id" type="hidden" />
                        <div class="form-group">
                            <label for="from-bank">จากธนาคาร</label>
                            <input type="text" class="form-control" id="from-bank" name="from_bank" placeholder="โอนเงินจากธนาคาร">
                        </div>
                        <div class="form-group">
                            <label for="to-bank">ถึงธนาคาร</label>
                            <input type="text" class="form-control" id="to-bank" name="to_bank" placeholder="โอนเงินถึงธนาคาร" required>
                        </div>
                        <div class="form-group">
                            <label for="total">จำนวนเงิน</label>
                            <input type="number" class="form-control" id="total" name="total" placeholder="จำนวนเงิน" required>
                        </div>
                        <div class="form-group">
                            <label for="transferred-on">วันที่-เวลา</label>
                            <input type="text" class="form-control" id="transferred-on" name="transferred_on" placeholder="วันที่-เวลา" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary" id="save-btn">บันทึก</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="modal-return-order">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ยกเลิกการสั่งซื้อและคืนเงิน</h4>
                </div>
                {!! Form::model($order->return_order, ['action' => ['BackendController@postReturnOrder', $order->id], 'method' => 'POST' ]) !!}

                <div class="modal-body">
                    {{--<form id="payment-form" method="POST" action="{{ action('BackendController@postReturnOrder', $order->id) }}">--}}
                        {!! csrf_field() !!}
                        {!! Form::hidden('order_id', $order->id) !!}
                        <div class="form-group">
                            {!! Form::label('bank_name', 'ชื่อธนาคาร') !!}
                            {!! Form::input('text', 'bank_name', null, ['class' => 'form-control', 'placeholder' => 'ชื่อธนาคาร', 'required' => 'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('bank_account_id', 'เลขที่บัญชี') !!}
                            {!! Form::input('text', 'bank_account_id', null, ['class' => 'form-control', 'placeholder' => 'เลขที่บัญชี', 'required' => 'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('bank_account_name', 'ชื่อบัญชี') !!}
                            {!! Form::input('text', 'bank_account_name', null, ['class' => 'form-control', 'placeholder' => 'ชื่อบัญชี', 'required' => 'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('amount', 'จำนวนเงิน') !!}
                            {!! Form::input('number', 'amount', null, ['class' => 'form-control', 'placeholder' => 'จำนวนเงิน', 'required' => 'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('transferred_on', 'วัน-เวลา ที่โอน') !!}
                            {!! Form::input('text', 'transferred_on', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
                {!! Form::close() !!}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop