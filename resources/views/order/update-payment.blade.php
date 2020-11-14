@extends('layouts.master')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('datetimepicker-master/jquery.datetimepicker.css') }}"/>
    <style>
        .order-box label{
            font-weight: normal;
        }

        .error {
            border-color: #f00;
        }

        div.error {
            border: 1px solid #f00;
        }
        label.error {
            margin: 10px 0px 0px 0px;
            padding: 0px;
            color: #f00;
            font-weight: normal;
            border: none;
        }

        .box {
            background: #fff;
            border: solid 1px #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 25px;
        }

        .table-form > tbody > tr > td:first-child {
            width: 20%;
        }

        #order-table > tbody > tr > td {
            border-top: none;
        }

        .mobile-input-time {
            padding-left: 0px;
        }

        #update-transfer {
            text-align: right;
        }

        .table-form > tbody > .td-bank > td {
            text-align: left;
            padding-left: 20%;
        }

        @media (min-width: 481px) and (max-width: 800px) {
            #update-transfer {
                text-align: right;
                padding-right: 25px;
            }
        }

        @media (max-width: 480px) {
            .table-form > tr > td:first-child {
                display: inline-block;
            }

            .order-list {
                float: left;
            }

            .box {
                background: #fff;
                border: solid 1px #ddd;
                border-radius: 4px;
                margin-bottom: 20px;
                padding: 25px;
            }

            .text-right {
                text-align: left;
            }

            .table-form > tbody > .td-bank > td {
                text-align: left;
                padding-left: 0%;
            }

            #update-transfer {
                text-align: center;
            }
        }
        div.radio-column{
            vertical-align: top;
        }
        .box-content label{
            width: 100%;
            padding: 15px 0 25px 0;
            border-bottom: solid 1px #eee;
            cursor: pointer;

        }
        .box-title {
            margin-bottom: 15px;
        }
        @media(max-width: 767px){
            #update-transfer-btn{
                width:100%;
            }
            #label-bank{
                text-align: left !important;
                margin-left: 15px;
            }
            #page-informpayment.container{
                padding-right: 0px;
                padding-left: 0px;
            }
        }
    </style>
@stop
@section('script')

    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"></script>
    <script src="{{ asset('datetimepicker-master/jquery.datetimepicker.js') }}"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery('#pay-on').datetimepicker({
                format: 'd/m/Y H:i',
                step: 1,
                inline: false,
                lang: 'th'
            });

            $('#payment-form').validate({
                errorPlacement: function (error, element) {
                    if (element.attr("name") == "to_bank") {
                        alert("เลือกธนาคารปลายทาง");
                    } else {
                        $(element).addClass('error');
                    }
                }
            });

            $(".select-id").change(function() {
                var element = $(this);
                var order_id_element = $("#order-id");
                if(element.val() == "") {
                    order_id_element.removeAttr("disabled");
                } else {
                    order_id_element.attr("disabled", true);
                }

                order_id_element.val(element.val());

                if(element.data("sub-total") != "") {
                    $("#total-transferred").val(element.data("sub-total"));
                }
            });

            $("#order-id").val($("input[name=order_id]:checked").val());
            $("#total-transferred").val($("input[name=order_id]:checked").data("sub-total"));
        });
    </script>
@stop
@section('content')
    <div id="page-informpayment" class="container">
        <div class="row has-order">
            <input name="_token" type="hidden" id="token" value="{{ csrf_token() }}"
                   data-url="{{ action('OrderController@postOrderPayment') }}"/>
            <div id="checkout" class="col-sm-12">
                @if(\Session::has('message'))
                    <div class="alert alert-success"><i class="fa fa-check-circle"></i>&nbsp;{{ \Session::get('message') }}</div>
                @endif
                @if($errors->has())
                    <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i>&nbsp;{{ $errors->first() }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger"><b>เกิดข้อผิดพลาด:&nbsp;</b>{{ $errors->first() }}</div>
                @endif
                <form class="form-horizontal"
                      id="payment-form"
                      action="{{ action('OrderController@postUpdatePayment') }}"
                      method="post"
                      accept-charset="utf-8"
                      enctype='multipart/form-data'>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <h3 ><strong>แจ้งชำระเงิน</strong></h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 pull-right">
                            <div class="panel">
                                <div class="panel-heading">บัญชีธนาคารของเรา</div>
                                <div class="panel-body">
                                    <p class="text-center">
                                        <strong>ชื่อบัญชี</strong>
                                    </p>
                                    <p class="text-center">
                                        <strong>มูบาซ่า โดย นายชาวพุทธ นวกาลัญญู</strong>
                                    </p>
                                    <hr>
                                    <label class="bank-item row">  
                                        <div class="bank-img col-xs-3">
                                            <img src="{{ asset('images/icon/bangkok-bank.jpg') }}">
                                        </div>
                                        <div class="bank-detail col-xs-9">
                                           <strong>ธนาคารกรุงเทพ</strong>
                                            <br>616-7-132742
                                        </div>
                                    </label>
                                    <br>
                                    <label class="bank-item row">
                                        <div class="bank-img col-xs-3">
                                            <img src="{{ asset('images/icon/ktb.jpg') }}">
                                        </div>
                                        <div class="bank-detail col-xs-9">
                                            <strong>ธนาคารกรุงไทย</strong>
                                            <br>443-0-59537-2
                                        </div>
                                    </label>
                                    <br>
                                    <label class="bank-item row">
                                        <div class="bank-img col-xs-3">
                                            <img src="{{ asset('images/icon/kasikorn-bank.jpg') }}">
                                        </div>
                                        <div class="bank-detail col-xs-9">
                                           <strong>ธนาคารกสิกรไทย</strong>
                                            <br>512-2-51660-3
                                        </div>
                                    </label>
                                    <br>
                                    <label class="bank-item row">
                                        <div class="bank-img col-xs-3">
                                            <img src="{{ asset('images/icon/logo-tmb.png') }}">
                                        </div>
                                        <div class="bank-detail col-xs-9">
                                            <strong>ธนาคารทหารไทย</strong>
                                            <br>465-2-23726-6
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <form class="form-horizontal"
                                  id="payment-form"
                                  action="{{ action('OrderController@postUpdatePayment') }}"
                                  method="post"
                                  accept-charset="utf-8"
                                  enctype='multipart/form-data'>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="panel">
                                <div class="panel-heading">
                                    แจ้งชำระเงิน
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="select-id" class="col-sm-3 col-xs-3 control-label">
                                            <span class="text-danger">*</span>
                                            รายการสั่งซื้อ:
                                        </label>
                                        <div class="col-sm-9 col-xs-9">
                                            @foreach($orders as $key => $order)
                                                <label>
                                                    <div class="column radio-column">
                                                        <input type="radio" name="order_id"
                                                               class="select-id" value="{{ $order->id }}"
                                                               {{ $order->id == $selected_id ? 'checked' : '' }}
                                                               data-sub-total="{{ $order->sub_total }}">
                                                        &nbsp;
                                                    </div>
                                                    <div class="column">
                                                        <span>
                                                            หมายเลขสั่งซื้อ: {{ $order->id }}
                                                            <br>วันที่สั่งซื้อ: {{ $order->created_at->format('d/m/Y') }}
                                                            <br><strong>ยอดรวม: {{ number_format($order->sub_total, 2) }} บาท</strong>
                                                        </span>
                                                    </div>
                                                </label>
                                            <div class="clear-fix"></div>
                                            @endforeach
                                            
                                            <label>
                                                <div class="column radio-column">
                                                    <input type="radio" name="order_id" class="select-id" value="">
                                                    &nbsp;
                                                </div>
                                                <div class="column">
                                                    <span >
                                                        ระบุหมายเลขสั่งซื้อเอง
                                                    </span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    
                                    <div class="form-group">
                                        <label for="order_id" class="col-sm-3 col-xs-3 control-label">
                                            <span class="text-danger">*</span>
                                            หมายเลขสั่งซื้อ:
                                        </label>

                                        <div class="col-sm-9 col-xs-9">
                                            <input type="number" id="order-id" class="form-control input payment-mobile-input"
                                             placeholder="หมายเลขสั่งซื้อไม่ต้องมีเลข 0 นำหน้า"
                                             name="order_id" data-min="0" required disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="total-transferred"
                                               class="col-sm-3 col-xs-3 control-label">
                                            <span class="text-danger">*</span>
                                            ยอดเงินที่โอน:
                                        </label>

                                        <div class="col-sm-9 col-xs-9">
                                            <input type="number" id="total-transferred"
                                                   class="form-control input payment-mobile-input" placeholder="ยอดเงินที่โอน"
                                                   name="total" data-min="0" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pay-on" class="col-sm-3 col-xs-3 control-label">
                                            <span class="text-danger">*</span>
                                            วัน-เวลา ที่โอน:
                                        </label>

                                        <div class="col-sm-9 col-xs-9">
                                            <input type="text" id="pay-on" class="form-control input payment-mobile-input"
                                                   placeholder="วันที่โอน"  name="pay_on" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label id="label-bank" for="pay_on_date"
                                               class="col-sm-3 col-xs-12 control-label">
                                            <span class="text-danger">*</span>
                                            ธนาคารที่โอนเข้า:
                                        </label>
                                        <div class="col-sm-9">
                                            <div class="col-sm-12 ">
                                                <label class="bank-item">
                                                    
                                                    <div class="row">
                                                        <div class="column">
                                                            <input type="radio" class="input media-object" name="to_bank"
                                                               value="ธนาคารกรุงเทพ" required>
                                                        </div>
                                                        <div class="column">
                                                            <img width="30" class="media-object" src="{{ asset('images/icon/bangkok-bank.jpg') }}">
                                                        </div>
                                                        <div class="column text-middle">
                                                            <strong>ธนาคารกรุงเทพ</strong>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="col-sm-12 ">
                                                <label class="bank-item">
                                                    <div class="row">
                                                        <div class="column">
                                                            <input type="radio" class="input" name="to_bank" value="ธนาคารกสิกรไทย" required>
                                                        </div>
                                                        <div class="column">
                                                            <img width="30" class="media-object"
                                                             src="{{ asset('images/icon/kasikorn-bank.jpg') }}">
                                                        </div>
                                                        <div class="column">
                                                            <strong>ธนาคารกสิกรไทย</strong>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-12 ">
                                                <label class="bank-item">
                                                    <div class="row">
                                                        <div class="column">
                                                            <input type="radio" class="input" name="to_bank" value="ธนาคารกรุงไทย" required>
                                                        </div>
                                                        <div class="column">
                                                            <img width="30" class="media-object" src="{{ asset('images/icon/ktb.jpg') }}">
                                                        </div>
                                                        <div class="column">
                                                            <strong>ธนาคารกรุงไทย</strong>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-12 ">
                                                <label class="bank-item">
                                                    <div class="row">
                                                        <div class="column">
                                                            <input type="radio" class="input" name="to_bank" value="ธนาคารทหารไทย" required>
                                                        </div>
                                                        <div class="column">
                                                            <img width="30" class="media-object" src="{{ asset('images/icon/logo-tmb.png') }}">
                                                        </div>
                                                        <div class="column">
                                                            <strong>ธนาคารทหารไทย</strong>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="slip_upload" class="col-sm-3 col-xs-3 control-label">หลักฐานการโอน:</label>

                                        <div class="col-sm-9 col-xs-9">
                                            <input type="file" id="slip_upload" class="form-control input" name="slip_upload">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-3 col-xs-0">
                                        </div>

                                        <div class="col-sm-9 col-xs-12">
                                            <button type="submit" id="update-transfer-btn" class="btn btn-success btn-medium input">
                                        แจ้งชำระเงิน
                                    </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop