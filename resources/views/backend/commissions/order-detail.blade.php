@extends('backend.layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('js/timepicker/dist/jquery-ui-timepicker-addon.min.css') }}">
    <style>
        @media screen and (max-width: 480px) {
            .detail {
                min-height:200px;
                padding:15px 0 0 0;
                border-bottom:1px solid #ddd;
            }
        }
        .detail {
            min-height:380px;
            padding:15px 0 0 0;
        }
        .detail span {
            color:#2c3e50;
        }
        .detail img {
            width:250px;
            height:250px;
        }
        .titlebar {
            border-bottom:1px solid #ddd;
            padding-bottom: 10px;
        }
        table {
            width:100%;
            font-size:16px;
        }
        table td {
            line-height:40px;
        }

        img {
            text-align:center;
        }
        h4 {
            color:#e67e22;
        }
        #btn-confirm-payment,
        #btn-cancel-payment {
            width:100%;
            height:40px;
        }
        .error {
            border-color: #f00;
        }
        #table-manufacture-detail h3 {
            display:inline;
        }
        #table-manufacture-detail h2 {
            font-size:14px;
            color:#666;
        }
        #table-manufacture-detail>tbody>tr>td:nth-child(2) {
            text-align: left;
        }
    </style>
@stop
@section('script')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"> </script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"> </script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"> </script>
    <script src="{{ asset('js/timepicker/dist/jquery-ui-timepicker-addon.min.js') }}"></script>

    <script src="{{ asset('js/timepicker/dist/jquery-ui-sliderAccess.js') }}"></script>
    <script>
        $(function() {
            var myControl = {
                create: function (tp_inst, obj, unit, val, min, max, step) {
                    $('<input class="ui-timepicker-input" value="' + val + '" style="width:50%">')
                            .appendTo(obj)
                            .spinner({
                                min: min,
                                max: max,
                                step: step,
                                change: function (e, ui) { // key events
                                    // don't call if api was used and not key press
                                    if (e.originalEvent !== undefined)
                                        tp_inst._onTimeChange();
                                    tp_inst._onSelectHandler();
                                },
                                spin: function (e, ui) { // spin events
                                    tp_inst.control.value(tp_inst, obj, unit, ui.value);
                                    tp_inst._onTimeChange();
                                    tp_inst._onSelectHandler();
                                }
                            });
                    return obj;
                },
                options: function (tp_inst, obj, unit, opts, val) {
                    if (typeof(opts) == 'string' && val !== undefined)
                        return obj.find('.ui-timepicker-input').spinner(opts, val);
                    return obj.find('.ui-timepicker-input').spinner(opts);
                },
                value: function (tp_inst, obj, unit, val) {
                    if (val !== undefined)
                        return obj.find('.ui-timepicker-input').spinner('value', val);
                    return obj.find('.ui-timepicker-input').spinner('value');
                }
            };

            $('#transferred-on').datetimepicker({
                controlType: myControl,
                dateFormat: 'dd/mm/yy',
                timeFormat: 'HH:mm'
            });

            $('#payment-save-modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var order_id = button.data('order-id'); // Extract info from data-* attributes
                var modal = $(this);
                modal.find('#order-id').val(order_id);
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

            $('.payment-edit-btn').click(function() {
                loadPaymentData($(this).data('payment-id'));
            });

            function loadPaymentData(id)
            {
                $.ajax({
                    type: "GET",
                    url: '/backend/load-payment-data/' + id,
                    dataType: "json",
                    success: function (data) {
                        if (data.result) {
                            $('#from-bank').val(data.payment.from_bank);
                            $('#to-bank').val(data.payment.to_bank);
                            $('#total').val(data.payment.total);
                            $('#transferred-on').val(data.payment.pay_on);
                            console.log(data.payment);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }
        });
    </script>
@stop
@section('content')
    <div class="titlebar"><h3>รายละเอียดการสั่งซื้อ</h3>
        <div class="pull-right">
            @if($order->payment_status->name != 'paid')
                <button type="submit" class="btn btn-primary" id="payment-save" data-toggle="modal" data-order-id="{{ $order->id }}" data-target="#payment-save-modal"><i class="fa fa-edit"></i>แจ้งชำระเงิน</button>
            @else
                <button type="submit" class="btn btn-warning payment-edit-btn" data-payment-id="{{ $order->payment[0]->id }}" data-toggle="modal" data-order-id="{{ $order->id }}" data-target="#payment-save-modal"><i class="fa fa-edit"></i>แจ้งชำระเงิน</button>
            @endif
            <a href="{{ action('BackendController@getUpdateOrder', $order->id) }}" class="btn warning">แก้ไขรายละเอียดารสั่งซื้อ</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="detail">
            <table>
                <tr>
                    <td align="center"><img src="{{ $order->campaign->design->back_cover ? $order->campaign->design->image_back_preview : $order->campaign->design->image_front_preview }}"></td>
                </tr>
            </table>
            <p><h4>รายการสั่งซื้อ​</h4></p>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>สินค้า</th>
                    <th>จำนวน</th>
                    <th>ราคา</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->allItems as $item)
                    <tr>
                        <td>
                            {{ $item->item->product->name }}&nbsp;{{ $item->item->product_image->color_name }}&nbsp;ขนาด&nbsp;{{ $item->size }}
                        </td>
                        <td>
                            {{ $item->qty }}
                        </td>
                        <td>
                            <span>฿</span>{{ $item->item->sell_price * $item->qty }}<span>&nbsp;THB</span>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2" class="text-right">ค่าจัดส่ง:</td>
                    <td>
                        <span>฿</span>{{ $order->shipping_cost }}<span>&nbsp;THB</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">รวมสุทธิ:</td>
                    <td>
                        <span>฿</span>{{ number_format($order->subTotal()) }}<span>&nbsp;THB</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="detail">
            <table id="table-detail" class="table">
                <thead>
                <tr>
                    <th colspan="2"><h4>รายละเอียดแคมเปญ</h4></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <tr><th>รหัสสั่งซื้อ :</th><td>{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td></tr>
                <tr>
                    <th>ชื่อแคมเปญ :</th><td><a
                                href="{{ action('SellController@showCampaign', $order->campaign->url) }}">{{ $order->campaign->title }}</a></td>
                </tr>
                <tr><th>ชื่อผู้สั่งซื้อ :</th><td><a
                                href="{{ action('UserController@getIndex', $order->user->getID()) }}">{{$order->user->full_name}}</a></td></tr>
                <tr>
                    <th>สถานะการผลิต :</th><td>{{ $order->campaign->produce_status->detail }}</td>
                </tr>
                <tr>
                    <th>วันที่สั่งซื้อ :</th><td>{{ $order->created_at }}</td>
                </tr>
                </tbody>
            </table>
            <table class="table">
                <thead>
                <tr>
                    <th colspan="2"><h4>รายละเอียดการชำระเงิน</h4></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>สถานะการชำระเงิน :</th><td>{{ $order->payment_status->detail }}</td>
                </tr>
                <tr>
                    <th>วันที่โอนเงิน :</th><td>{{ $order->payment[0]->getPayOnDate() }}</td>
                </tr>
                <tr>
                    <th>เวลาที่โอนเงิน :</th><td>{{ $order->payment[0]->getPayOnTime() }}</td>
                </tr>
                <tr>
                    <th>จำนวนเงิน:</th><td>{{ $order->payment[0]->total }}</td>
                </tr>
                <tr>
                    <th>ธนาคารที่โอนเข้า :</th><td>{{ $order->payment[0]->to_bank }}</td>
                </tr>
                <tr>
                    <th>ธนาคารต้นทาง :</th><td>{{ $order->payment[0]->from_bank }}</td>
                </tr>
                <tr>
                    <th>หลักฐานการโอนเงิน :</th><td>
                        @if($order->payment->first()->slip_upload)
                            <a href="{{ url('/') . '/' . $order->payment->first()->slip_upload }}" target="blank"><img src="{{ url('/') . '/' . $order->payment->first()->slip_upload }}" alt=""></a>
                        @else
                            ไม่มีข้อมูล
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="table">
                <thead>
                <tr>
                    <th colspan="2"><h4>ที่อยู่สำหรับการจัดส่ง</h4></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>ชื่อ-นามสกุล :</th><td>{{ $order->shipping_address->full_name }}</td>
                </tr>
                <tr>
                    <th>ที่อยู่ :</th><td>{{ $order->shipping_address->address }}</td>
                </tr>
                <tr>
                    <th>อาคาร :</th><td>{{ $order->shipping_address->building }}</td>
                </tr>
                <tr>
                    <th>เขต/อำเภอ:</th><td>{{ $order->shipping_address->district }}</td>
                </tr>
                <tr>
                    <th>จังหวัด :</th><td>{{ $order->shipping_address->province }}</td>
                </tr>
                <tr>
                    <th>รหัสไปรษณีย์ :</th><td>{{ $order->shipping_address->zipcode }}</td>
                </tr>
                <tr>
                    <th>หมายเลขโทรศัพท์ :</th><td>{{ $order->shipping_address->phone }}</td>
                </tr>
                </tbody>
            </table>
            @if($order->user->bank_account)
                <table class="table">
                    <thead>
                    <tr>
                        <th colspan="2"><h4>บัญชีธนาคารสำหรับรับเงินคืน</h4></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>ชื่อเจ้าของบัญชี :</th><td>{{ $order->user->bank_account->name }}</td>
                    </tr>
                    <tr>
                        <th>ชื่อธนาคาร :</th><td>{{ $order->user->bank_account->bank_name }}</td>
                    </tr>
                    <tr>
                        <th>สาขา :</th><td>{{ $order->user->bank_account->branch }}</td>
                    </tr>
                    <tr>
                        <th>เลขที่บัญชี:</th><td>{{ $order->user->bank_account->no }}</td>
                    </tr>
                    </tbody>
                </table>
            @endif
            <table class="table">
                <tbody>
                @if($order->payment_status->name === 'transferred')
                    <td><button
                                id="btn-confirm-payment" class="btn btn-green"
                                data-toggle="modal" data-target="#modal-confirm-payment">
                            <i class="fa fa-check"></i>&nbsp;ยืนยันการชำระเงิน</button>
                    </td>

                    <td>
                        <button id="btn-cancel-payment" class="btn btn-warning"
                                data-toggle="modal" data-target="#modal-cancel-payment">
                            <i class="fa fa-times"></i>&nbsp;ยกเลิก</button>
                    </td>
                @elseif($order->payment_status->name == 'paid' || $order->payment_status->name == 'cancel')
                    <td>
                        <button id="btn-cancel-payment" class="btn btn-warning"
                                data-toggle="modal" data-target="#modal-reset-payment">
                            รอตรวจสอบอีกครั้ง</button>
                    </td>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12" style="border-bottom:1px solid #ddd"></div>
    <div class="modal fade" id="modal-confirm-payment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ยืนยันการชำระเงิน</h4>
                </div>
                <div class="modal-body">
                    ต้องการยืนยันการชำระเงินรหัสสั่งซื้อ : {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} ยอดชำระ {{ $order->payment[0]->total }} บาท หรือไม่
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <a href="{{ action('BackendController@getConfirmTransfer', $order->id) }}" class="btn btn-success">ยืนยัน</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="modal-cancel-payment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ยกเลิกการชำระเงิน</h4>
                </div>
                <div class="modal-body">
                    ต้องการยกเลิกการชำระเงินรหัสสั่งซื้อ : {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} ยอดชำระ {{ $order->payment[0]->total }} บาท หรือไม่
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <a href="{{ action('BackendController@getCancelTransfer', $order->id) }}" class="btn btn-success">ยืนยัน</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
        <div class="modal fade" id="modal-reset-payment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">รอตรวจสอบการชำระเงิน</h4>
                </div>
                <div class="modal-body">
                    ต้องการรอตรวจสอบการชำระเงินรหัสสั่งซื้อ : {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} ยอดชำระ {{ $order->payment[0]->total }} บาท หรือไม่
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <a href="{{ action('BackendController@getResetUpdateTransfer', $order->id) }}" class="btn btn-success">ยืนยัน</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="payment-save-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">แจ้งการชำระเงิน</h4>
                </div>
                <div class="modal-body">
                    <form id="payment-form" method="POST" action="{{ action('BackendController@postUpdatePayment') }}">
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
@stop