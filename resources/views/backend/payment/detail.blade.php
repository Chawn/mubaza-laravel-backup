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
    </style>
@stop
@section('script')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"></script>
    <script src="{{ asset('datetimepicker-master/jquery.datetimepicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            jQuery('#transferred-on').datetimepicker({
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

            $('#save-btn').click(function () {
                if ($('#payment-form').valid()) {
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
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        รายละเอียดแจ้งชำระเงิน
                    </h3>
                </div>
                <div class="box-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>หมายเลขการแจ้งชำระเงิน:</td>
                            <td>{{ $payment->id }}</td>
                        </tr>
                        <tr>
                            <td>โอนเข้าธนาคาร:</td>
                            <td>{{ $payment->to_bank }}</td>
                        </tr>
                        <tr>
                            <td>วันที่:</td>
                            <td>{{ $payment->pay_on->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td>เวลา:</td>
                            <td>{{ $payment->pay_on->format('H:i') }} น.</td>
                        </tr>
                        <tr>
                            <td>จำนวนเงิน:</td>
                            <td>
                                <p>
                                        <span class="font-big">   
                                        {{ number_format($payment->total, 2) }}
                                        </span>
                                    @if ($payment->total == $payment->order->subTotal())
                                        <span class="text-danger">
                                                <i class="fa fa-check text-success"></i> ตรงกับยอดรวมสุทธิ
                                            </span>
                                    @else
                                        <span class="text-danger">
                                                <i class="fa fa-close text-danger"></i> ไม่ตรงกับยอดรวมสุทธิ
                                            </span>
                                    @endif
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>การแจ้งชำระเงินที่ใกล้เคียง:</td>
                            <td>
                                @forelse($nearest_payments as $nearest_payment)
                                    <p>
                                        รหัสสั่งซื้อ <a href="{{ action('BackendController@getOrderDetail', $nearest_payment->order_id) }}">#{{ str_pad($nearest_payment->order_id, 6, 0, STR_PAD_LEFT) }}</a>
                                        รหัสการแจ้งชำระเงิน <a
                                                href="{{ action('BackendController@getPaymentDetail', $nearest_payment->id) }}">#{{ str_pad($nearest_payment->id, 6, 0, STR_PAD_LEFT) }}</a>
                                    </p>
                                @empty
                                    -
                                @endforelse
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-sm-3">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">เครื่องมือ</div>
                </div>
                <div class="box-body">
                    @if($payment->order->payment_type->name == 'transfer')
                        <div class="">
                            @if($payment->order->payment_status->name == 'approve')
                                <button class="btn btn-success btn-block"
                                        data-toggle="modal" data-target="#modal-confirm-payment">
                                    <i class="fa fa-check"></i> อนุมัติ
                                </button>
                                <button class="btn btn-danger btn-block"
                                        data-toggle="modal" data-target="#modal-cancel-payment">
                                    <i class="fa fa-times"></i> ไม่อนุมัติ
                                </button>

                            @elseif($payment->order->payment_status->name == 'paid')
                                <button class="btn btn-warning btn-lg"
                                        data-toggle="modal" data-target="#modal-reset-payment">
                                    <i class="fa fa-refresh"></i> รอตรวจสอบอีกครั้ง
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-9">
            <section class="box">
                <div class="box-header">
                    <h3 class="box-title">รายละเอียดการสั่งซื้อ</h3>
                </div>
                <div class="box-body">
                    <p>
                        รหัสสั่งซื้อ: #{{ $payment->order->id }}
                    </p>
                    <p>
                        วันที่สั่งซื้อ: {{ $payment->order->created_at->format('d/m/Y') }}
                    </p>
                    <p>
                        สถานะการชำระเงิน: 
                        <span class="{{ $payment->order->payment_status->name=='paid' ? 'text-success' : 'text-danger' }}">{{ $payment->order->payment_status->detail }}
                        </span>
                    </p>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <td>SKU</td>
                            <td>สินค้า</td>
                            <td>จำนวน</td>
                            <td>ราคาต่อหน่วย</td>
                            <td>ราคารวม</td>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($payment->order->items as $item)
                            <tr>
                                <td>{{ $item->sku->id }}</td>
                                <td>
                                    {{ $item->campaign->title }}
                                    - {{ $item->sku->color->product->name }} {{ $item->sku->color->name }} {{ $item->sku->size }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>฿{{ number_format($item->campaign_product->sell_price, 2) }}</td>
                                <td>฿{{ number_format($item->total(), 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">ไม่มีรายการ</td>
                            </tr>
                        @endforelse
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4" class="text-right">ภาษี (0%)</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">ค่าจัดส่ง:</td>
                            <td>฿{{ number_format($payment->order->shipping_cost, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">ส่วนลด:</td>
                            <td>฿{{ number_format($payment->order->coupon_discount_total, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">
                                <strong>รวมสุทธิ:</strong>
                            </td>
                            <td>
                                <strong>
                                    ฿{{ number_format($payment->order->subTotal(), 2) }}
                                </strong>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                    <p class="text-center">
                        ข้อมูลล่าสุดวันที่ {{ $payment->order->updated_at->format('d/m/Y') }}
                    </p>
                </div>
            </section>
        </div>
    </div>


    @if($payment->order->payment_status->name == 'approve')
        <div class="modal fade" id="modal-confirm-payment">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">ยืนยันการชำระเงิน</h4>
                    </div>
                    <div class="modal-body">
                        ต้องการยืนยันการชำระเงินรหัสสั่งซื้อ : {{ str_pad($payment->order->id, 6, '0', STR_PAD_LEFT) }}
                        ยอดชำระ {{ $payment->total }} บาท หรือไม่
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                        <a href="{{ action('BackendController@getConfirmPayment', $payment->id) }}"
                           class="btn btn-success">ยืนยัน</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal fade" id="modal-cancel-payment">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">ยกเลิกการชำระเงิน</h4>
                    </div>
                    <div class="modal-body">
                        ต้องการยกเลิกการชำระเงินรหัสสั่งซื้อ : {{ str_pad($payment->order->id, 6, '0', STR_PAD_LEFT) }}
                        หรือไม่
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                        <a href="{{ action('BackendController@getCancelPayment', $payment->id) }}"
                           class="btn btn-success">ยืนยัน</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @elseif($payment->order->payment_status->name == 'paid')
        <div class="modal fade" id="modal-reset-payment">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">ตรวจสอบการชำระเงินอีกครั้ง</h4>
                    </div>
                    <div class="modal-body">
                        ตรวจสอบการชำระเงินรหัสสั่งซื้อ : {{ str_pad($payment->order->id, 6, '0', STR_PAD_LEFT) }}
                        ยอดชำระ {{ $payment->total }} บาท หรือไม่
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                        <a href="{{ action('BackendController@getResetUpdatePayment', $payment->id) }}"
                           class="btn btn-success">ยืนยัน</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @endif
    <div class="modal fade" id="payment-save-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">แจ้งการชำระเงิน</h4>
                </div>
                <div class="modal-body">
                    <form id="payment-form" method="POST"
                          action="{{ action('BackendController@postUpdatePayment', $payment->order->id) }}">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <input name="order_id" id="order-id" type="hidden"/>
                        <div class="form-group">
                            <label for="from-bank">จากธนาคาร</label>
                            <input type="text" class="form-control" id="from-bank" name="from_bank"
                                   placeholder="โอนเงินจากธนาคาร">
                        </div>
                        <div class="form-group">
                            <label for="to-bank">ถึงธนาคาร</label>
                            <input type="text" class="form-control" id="to-bank" name="to_bank"
                                   placeholder="โอนเงินถึงธนาคาร" required>
                        </div>
                        <div class="form-group">
                            <label for="total">จำนวนเงิน</label>
                            <input type="number" class="form-control" id="total" name="total" placeholder="จำนวนเงิน"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="transferred-on">วันที่-เวลา</label>
                            <input type="text" class="form-control" id="transferred-on" name="transferred_on"
                                   placeholder="วันที่-เวลา" required>
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