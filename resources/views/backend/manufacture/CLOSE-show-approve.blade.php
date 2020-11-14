@extends('backend.layouts.master')
@section('css')
    <style>
        th {
            text-align: center;
        }
        .small-text {
            font-size: 12px;
        }
        #campaign-detail-img img{
            max-width: 100%;
        }
        #group-btn-flip {
            margin: -20px 0 20px 0;
            text-align: center;
        }
        .btn-backend-flip-img {
            padding: 5px 15px;
            border-radius: 35px;
            background: #ddd;
            color: #202020;
            border: 1px solid transparent;
            text-align: center;
            vertical-align: middle;
            margin-right: 10px;
        }
        .btn-backend-flip-img:focus {

        }
        .btn-backend-flip-img:active {

            border: 1px solid transparent;
        }
        .flip-choose {
            background: #202020;
            color: #fff;
        }
        .flip-choose:hover {
            background: #202020;
            color: #fff;
        }
        .flip-choose:focus {
            background: #202020;
            color: #fff;
        }
    </style>
@stop
@section('script')
    <script>
        $(document).ready(function() {
            $('#campaign-detail-img-back').hide();
            $("#flip-font").click(function () {
                $("#campaign-detail-img-font").show();
                $("#campaign-detail-img-back").hide();
            });
            $("#flip-back").click(function () {
                $("#campaign-detail-img-font").hide();
                $("#campaign-detail-img-back").show();
            });
            $(".btn-backend-flip-img").click(function() {
                $(".btn-backend-flip-img.flip-choose").removeClass("flip-choose");
                $(this).addClass("flip-choose");
            });
            $('.btn-block').click(function() {
                $.ajax({
                    method: 'POST',
                    url: '/backend/update-block-count/' + $(this).data('campaign-id'),
                    data: {
                        _token: $("input[name=_token]").val(),
                        block_front_count: $('#block-front-count').val(),
                        block_back_count: $('#block-back-count').val()
                    },
                    dataType: "json",
                    success: function (data) {
                        if(data.error)
                        {
                            alert(data.message);
                        }
                        else
                        {
                            alert(data.message);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            });
            $('#charge-card').click(function()
            {
                var len = $('.card-payment').length;
                $('.card-payment').each(function(k, v)
                {
                    var current_tr = $(this);
                    current_tr.find('.icon-status i').removeClass('fa-exclamation');
                    current_tr.find('.icon-status i').addClass('fa-spinner fa-pulse');
                    $.ajax({
                        method: 'GET',
                        url: '/backend/charge-card/' + $(this).data('order-id'),
                        dataType: "json",
                        success: function (data) {
                            if(!data.error) {
                                if(data.success)
                                {
                                    current_tr.find('.icon-status i').removeClass('fa-spinner fa-pulse');
                                    current_tr.find('.icon-status i').addClass('fa-check');
                                    current_tr.removeClass('card-payment');
                                    current_tr.removeClass('danger');
                                    current_tr.addClass('charged')
                                }
                                else
                                {
                                    current_tr.find('.icon-status i').attr('title', data.message);
                                    current_tr.addClass('danger');
                                    current_tr.find('.icon-status i').removeClass('fa-spinner fa-pulse');
                                    current_tr.find('.icon-status i').addClass('fa-exclamation');
                                }
                            }
                            else
                            {

                            }
                            if(k == (len - 1))
                            {
                                 setTimeout(function() {
                                     $("#charge-card").addClass("hidden");
                                     $("#confirm-button").removeClass("hidden");
                                 }, 2000);
                            }
                        },
                        failure: function (errMsg) {
                            alert(errMsg);
                        }
                    });
                });
            });
        });
    </script>
@stop
@section('content')
    @if($errors->has())
        <div class="alert alert-warning"><i class="fa fa-exclamation"></i>&nbsp;{{ $errors->first() }}</div>
    @endif
    <h3>{{ $title }}</h3>
    <div class="clear-fix">&nbsp;</div>
    <div class="row">
        <div class="col-md-6 text-center">
            <div id="campaign-detail-img">
                <img id="campaign-detail-img-font" src="{{ $campaign->design->image_front_preview }}">
                <img id="campaign-detail-img-back" src="{{ $campaign->design->image_back_preview }}">
            </div>
            <div id="group-btn-flip">
                <a id="flip-font" class="btn btn-backend-flip-img flip-choose" href="javascript:void(0)">ด้านหน้า</a>
                <a id="flip-back" class="btn btn-backend-flip-img " href="javascript:void(0)">ด้านหลัง</a>
            </div>

        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-md-6" id="block-count">
            <h2>ตรวจสอบจำนวนสีที่ใช้สกรีน</h2>
            <hr>
            <h3>ด้านหน้า
                <input type="number" name="block_front_count" id="block-front-count" value="{{ $campaign->design->block_front_count }}">
                สี
            </h3>
            <br>
            <p><h3>
                ด้านหลัง
                <input type="number" name="block_back_count" id="block-back-count" value="{{ $campaign->design->block_back_count }}">
                สี
            </h3>
            </p>
            <br><br>
            <button type="submit" class="btn btn-success btn-lg btn-block" data-campaign-id="{{ $campaign->id }}">บันทึก</button>
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-money"></i>&nbsp;กำไร</h3>
                </div>
                <div class="panel-body">
                    <h3>{{ number_format($campaign->totalProfit(), 2) }}</h3>
                    <p class="small-text">จากยอดขายทั้งหมด: {{ number_format($campaign->totalPayment(), 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-shopping-cart"></i>&nbsp;ขายได้</h3>
                </div>
                <div class="panel-body">
                    <h3>{{ $campaign->totalOrder() }} ตัว</h3>
                    <p class="small-text">จากเป้าหมายที่ตั้งไว้: {{ $campaign->goal }} ตัว</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-exchange"></i>&nbsp;ยอดโอนเงิน</h3>
                </div>
                <div class="panel-body">
                    <h3>{{ number_format($campaign->totalTransferred(), 2) }}</h3>
                    <p class="small-text">จากจำนวนเงินทั้งหมด: {{ number_format($campaign->totalTransfer(), 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-credit-card"></i>&nbsp;ยอดผ่านบัตรเครดิต</h3>
                </div>
                <div class="panel-body">
                    <h3>{{ number_format($campaign->totalCardCharged(), 2) }}</h3>
                    <p class="small-text">จากจำนวนเงินทั้งหมด: {{ number_format($campaign->totalCard(), 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12 col-md-offset-4">
            <p class="pull-right">

                <button class="btn btn-lg btn-warning {{ $card_orders->count() <= 0 ? 'hidden' : '' }}" data-url="{{ action('BackendController@getSetWaitingCampaign', $campaign->id) }}" id="charge-card"><i class="fa fa-cog"></i>&nbsp;ดำเนินการชำระเงินผ่านบัตร</button>
                <button id="confirm-button" class="btn btn-lg btn-success  {{ $card_orders->count() <= 0 ? '' : 'hidden' }}" data-toggle="modal" data-target="#confirm-produce"><i class="fa fa-check"></i>&nbsp;ดำเนินการผลิต</button>
                <button id="cancel-button" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#confirm-cancel"><i class="fa fa-trash"></i>&nbsp;ยกเลิกแคมเปญนี้</button>

            </p>
        </div>
    </div>
    <hr/>
    <div class="table-responsive">
        <div><div class="pull-left"><h4><i class="fa fa-credit-card"></i>&nbsp;ข้อมูลการชำระเงินด้วยบัตรเครดิตหรือบัตรเดบิต</h4></div>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>เลขที่สั่งซื้อ</th>
                    <th>ชื่อผู้สั่งซื้อ</th>
                    <th>วันที่สั่ง</th>
                    <th>จำนวนเงิน</th>
                    <th>จำนวนเงินที่ชำระ</th>
                    <th>ธนาคารที่ชำระ</th>
                    <th>สถานะการชำระเงิน</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @forelse($card_orders as $order)
                    <tr class="{{ $order->payment->first()->is_charged ? 'charged' : 'card-payment danger' }}" data-order-id="{{ $order->id }}">
                        <td><a href="{{ action('BackendController@getPaymentDetail', $order->id) }}">{{ $order->id }}</a></td>
                        <td><a href="{{ action('UserController@getIndex', $order->user->getID())}}">{{ $order->user->full_name }}</a></td>
                        <td>{{ $order->created_at }}</td>
                        <td align="right">{{ number_format($order->subTotal()) }}</td>
                        <td align="right">{{ number_format($order->payment->first()->total) }}</td>
                        <td>{{ $order->payment->first()->from_bank }}</td>
                        <td>{{ $order->payment_status->detail }}</td>
                        <td align="center" class="icon-status">
                            @if($order->payment_status->name = 'paid_by_card')
                                @if($order->payment->first()->is_charged)
                                    <i class="fa fa-check"></i>
                                @else
                                    <i class="fa fa-exclamation"  data-toggle="tooltip" data-placement="top" title="{{ $order->payment->first()->remark }}"></i>
                                @endif
                            @endif
                            @if($order->payment_status->name == 'waiting')
                                <i class="fa fa-times"></i>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">ไม่มีข้อมูลการสั่งซื้อ</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <hr/>
        <h4><i class="fa fa-exchange"></i>&nbsp;ข้อมูลการชำระเงินด้วยการโอนเงินผ่านธนาคาร</h4>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>เลขที่สั่งซื้อ</th>
                <th>ชื่อผู้สั่งซื้อ</th>
                <th>วันที่สั่ง</th>
                <th>จำนวนเงิน</th>
                <th>จำนวนเงินที่โอน</th>
                <th>ธนาคารที่โอน</th>
                <th>สถานะการชำระเงิน</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($transfer_orders as $order)
                <tr class="{{ $order->payment_status->name != 'paid' ? 'danger' : '' }}">
                    <td><a href="{{ action('BackendController@getPaymentDetail', $order->id) }}">{{ $order->id }}</a></td>
                    <td><a href="{{ action('UserController@getIndex', $order->user->getID())}}">{{ $order->user->full_name }}</a></td>
                    <td>{{ $order->created_at }}</td>
                    <td align="right">{{ number_format($order->subTotal()) }}</td>
                    <td align="right">{{ number_format($order->payment->first()->total) }}</td>
                    <td>{{ $order->payment->first()->from_bank }}</td>
                    <td>{{ $order->payment_status->detail }}</td>
                    <td align="center">
                        @if($order->payment_status->name == 'paid')
                            <i class="fa fa-check"></i>
                        @else
                            <i class="fa fa-exclamation" style="color:#ff9933"></i>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">ไม่มีข้อมูลการสั่งซื้อ</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <!-- Confirm cancel campaign dialog box -->

    <div class="modal fade" id="confirm-cancel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ยืนยันการยิกเลิก</h4>
                </div>
                <div class="modal-body">
                    <p>คุณแน่ใจว่าต้องการยกเลิกการผลิตแคมเปญนี้</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;ปิด</button>
                    <a href="{{ action('BackendController@getCloseCampaign', $campaign->id) }}" class="btn btn-lg btn-danger"><i class="fa fa-check"></i>&nbsp;ยืนยัน</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End comfirm dialog box -->

    <!-- Confirm product campaign dialog box -->

    <div class="modal fade" id="confirm-produce">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ยืนยันการดำเนินการผลิต</h4>
                </div>
                <div class="modal-body">
                    <p>คุณแน่ใจว่าต้องการดำเนินการผลิตแคมเปญนี้</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;ปิด</button>
                    <a href="{{ action('BackendController@getSetWaitingCampaign', $campaign->id) }}" class="btn btn-lg btn-primary"><i class="fa fa-check"></i>&nbsp;ยืนยัน</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End comfirm dialog box -->
@stop