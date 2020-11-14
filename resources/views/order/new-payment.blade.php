@extends('layouts.full_width')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('css')
    <style>
        .order-list {
            background: #fff;
            float: right;
        }
        .error {
            border-color: #f00;
        }
        label.error {
            margin: 10px 0px 0px 0px;
            padding: 0px;
            color: #f00;
            font-weight: normal;
            border: none;
        }
        .box{
            background: #fff;
            border: solid 1px #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 25px;
        }
        .table-form>tbody>tr>td:first-child {
            width: 20%;
        }
        #order-table>tbody>tr>td {
            border-top: none;
        }
        .mobile-input-time{
            padding-left: 0px;
        }
        #update-transfer {
            text-align: right;
        }
        .table-form>tbody>.td-bank>td{
                text-align: left;
                padding-left: 20%;
            }
        @media (min-width: 481px) and (max-width: 800px) {
            #update-transfer {
                text-align: right;
                padding-right: 25px;
            }
        }
        @media (max-width: 480px){
            .table-form> tr> td:first-child {
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
            .table-form>tbody>.td-bank>td{
                text-align: left;
                padding-left: 0%;
            }
            #update-transfer {
                text-align: center;
            }
        }
    </style>
    @stop
@section('script')

    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"> </script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"> </script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"> </script>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var order_payment = [];
        var total = 0;

        Number.prototype.padLeft = function (n,str){
            return Array(n-String(this).length+1).join(str||'0')+this;
        };

        $("#pay_on_date").datepicker({ 
                changeMonth: true, 
                changeYear: true,
                dateFormat: 'dd/mm/yy', 
                isBuddhist: true, 
                dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
                dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
                monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
                monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']
            });

        $('#order-id').change(function() {
           loadOrderData();
        });

        function loadOrderPayment(url, token, user_id) {
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    user_id: user_id
                },
                dataType: "json",
                success: function (data) {
                    if (!data.error) {
                        order_payment = data;
                        createOrderIDSelect();
                        loadOrderData($('#order-id').val());
                        reValidate();
                    }
                    else
                    {
                        $('.has-order').addClass('hidden');
                        $('.empty').removeClass('hidden');
                    }

                },
                failure: function (errMsg) {
                    alert(errMsg);
                }
            });
        }

        function createOrderIDSelect() {
            var option = "";
            $.each(order_payment, function(k, v) {
                var campaign_name = v.campaign.title;
                if(v.campaign.type.name == "buy")
                {
                    campaign_name = "ออกแบบเพื่อสั่งซื้อ";
                }
               option += '<option value="' + v.id + '">#'+ v.id + " - " + campaign_name + '</option>';
            });

            $('#order-id').html(option);
        }

        function loadOrderData() {
            var order = $(order_payment).filter(function () {
                return this.id == $('#order-id').val();
            })[0];
            var row = '';
            $.each(order.all_items, function(k, item) {
                var sub_total = (item.item.sell_price * item.qty);
                row += '<p>' + item.item.product.name + '&nbsp'
                + item.item.product_image.color_name + '&nbsp;'
                + item.size + '&nbsp;' +
                + item.qty + '&nbsp;ตัว'
                + '<span class="pull-right">' + sub_total + '</span></p>';
            });
            $('.basket-items').html(row);

            $('#show-transport-cost span').html('฿ ' + order.shipping_cost);
            $('#total').html(order.sub_total);
            $('#total-transferred').attr('data-min', order.sub_total);
            $('#total-transferred').val(order.sub_total);

            $('#update-transfer-btn').click(function() {
               if($('#payment-form').valid())
               {
                   $(this).attr('disabled', 'disabled');
                   $(this).html('<i class="fa fa-spinner fa-pulse"></i>&nbsp;กรุณารอสักครู่');
                   $('#payment-form').submit();
               }
            });

        }
        function reValidate()
        {
            $('#payment-form').validate({
                rules: {
                    total: {
                        required: true,
                        min: $('#total-transferred').attr('data-min')
                    }
                },
                errorPlacement: function (error, element) {
                    // Append error within linked label
//                    error.insertAfter(element);
                    if(element.attr("name") == "total") {

                    } else {
                        $(element).addClass('error');
                    }
                }
            });
        }

        reValidate();
        loadOrderPayment($('#token').data('url'), $('#token').val(), $('#user-id').val());

    });
</script>
@stop
@section('css')
<style type="text/css" media="screen">
    .input-time{
        max-width: 70px!important;
    }
    .row .empty{
        min-height: 300px;
    }
</style>
@stop
@section('content')
<div id="page-informpayment" class="container ">
    <div class="row empty hidden"><div class="alert text-center">ไม่มีรายการสั่งซื้อในขณะนี้</div></div>
    <div class="row has-order">
        <input name="_token" type="hidden" id="token" value="{{ csrf_token() }}" data-url="{{ action('OrderController@postOrderPayment') }}"/>
        <div id="checkout">
            <div class="col-md-8 col-sm-12 col-xs-12">
                @if($errors->any())
                        <div class="alert alert-danger"><b>เกิดข้อผิดพลาด:&nbsp;</b>{{ $errors->first() }}</div>
                @endif
               <form class="form-horizontal"
                     id="payment-form"
                     action="{{ action('OrderController@postUpdateTransfer') }}"
                     method="post"
                     accept-charset="utf-8"
                     enctype='multipart/form-data'>
                   <input name="user_id" type="hidden" id="user-id" value="{{ \Auth::user()->user()->id }}"/>
                    <div class="box box-noneborder box-nonepad-bottom">
                        <div class="box-title font-title">
                            แจ้งชำระเงิน
                        </div>
                       <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                       <div class="form-group">
                           <label for="order_id" class="col-sm-3 col-xs-3 control-label">รหัสสั่งซื้อ:</label>
                           <div class="col-sm-9 col-xs-9">
                               <select class="form-control payment-mobile-input" name="order_id" id="order-id">
                                </select>
                           </div>
                       </div>
                       <div class="form-group">
                           <label for="total-transferred" class="col-sm-3 col-xs-3 control-label">ยอดเงินที่โอน:</label>
                           <div class="col-sm-9 col-xs-9">
                               <input type="number" id="total-transferred" class="form-control input payment-mobile-input" placeholder="ยอดเงินที่โอน"
                                           name="total" data-min="0" required>
                           </div>
                       </div>
                       <div class="form-group">
                           <label for="pay_on_date" class="col-sm-3 col-xs-3 control-label">วันที่โอน:</label>
                           <div class="col-sm-9 col-xs-9">
                                <input type="text" id="pay_on_date" class="form-control input payment-mobile-input" 
                                        placeholder="วันที่โอน" name="pay_on_date" required>
                           </div>
                       </div>
                       <div class="form-group">
                           <label for="pay_on_time" class="col-sm-3 col-xs-3 control-label">เวลา:</label>
                           <div class="col-sm-2 col-xs-4">
                                <select class="form-control input" name="hour" id="hour">
                                    @for($i = 1; $i < 25; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                           </div>
                           <div class="col-sm-2 col-xs-4">
                                <select class="form-control input" name="minute" id="minute">
                                    @for($i = 1; $i <= 60; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                           </div>
                       </div>
                        <div class="form-group">
                            <label for="pay_on_date" class="col-sm-3 col-xs-3 control-label">ธนาคารที่โอนเข้า:</label>
                            <div class="col-sm-11 col-sm-offset-1">
                                <label class="bank-item">
                                    <input type="radio" class="input media-object" name="to_bank" value="ธนาคารกรุงเทพ" required>
                                    <div class="media-left media-middle">
                                            <img class="media-object" src="{{ asset('images/icon/bangkok-bank.jpg') }}">
                                    </div>
                                    <div class="media-body">
                                        <p class="media-heading">ธนาคารกรุงเทพ สาขา เซ็นทรัลพลาซา อุดรธานี</p>
                                        <p>ชื่อบัญชี: ร้าน มูบาซ่า</p>
                                        <p>เลขที่บัญชี: 616-7-132742</p>
                                    </div>
                                </label>
                            </div>
                            <div class="col-sm-11 col-sm-offset-1">
                                <label class="bank-item">
                                    <input type="radio" class="input" name="to_bank" value="ธนาคารกรุงไทย" required>
                                    <div class="media-left media-middle">
                                        <img class="media-object" src="{{ asset('images/icon/ktb.jpg') }}">
                                    </div>
                                    <div class="media-body">
                                        <p class="media-heading"> ธนาคารกรุงไทย สาขา เซ็นทรัลพลาซา อุดรธานี</p>
                                        <p>ชื่อบัญชี: มูบาซ่า โดย นายชาวพุทธ นวกาลัญญู</p>
                                        <p>เลขที่บัญชี: 443-0-59537-2</p>
                                    </div>
                                </label>
                            </div>
                            <div class="col-sm-11 col-sm-offset-1">
                                <label class="bank-item">
                                    <input type="radio" class="input" name="to_bank" value="ธนาคารกสิกรไทย" required>
                                    <div class="media-left media-middle">
                                        <img class="media-object" src="{{ asset('images/icon/kasikorn-bank.jpg') }}">
                                    </div>
                                    <div class="media-body">
                                        <p class="media-heading">ธนาคารกสิกรไทย สาขา เซ็นทรัลพลาซา อุดรธานี</p>
                                        <p>ชื่อบัญชี: ร้าน มูบาซ่า</p>
                                        <p>เลขที่บัญชี: 512-2-51660-3</p>
                                    </div>
                                </label>
                            </div>
                            <div class="col-sm-11 col-sm-offset-1">
                                <label class="bank-item">
                                    <input type="radio" class="input" name="to_bank" value="ธนาคารทหารไทย" required>
                                    <div class="media-left media-middle">
                                        <img class="media-object" src="{{ asset('images/icon/logo-tmb.png') }}">
                                    </div>
                                    <div class="media-body">
                                        <p class="media-heading">ธนาคารทหารไทย สาขา ถนนโพศรี อุดรธานี</p>
                                        <p>ชื่อบัญชี: ร้าน มูบาซ่า</p>
                                        <p>เลขที่บัญชี: 465-2-23726-6</p>
                                    </div>
                                </label>
                            </div>
                       </div>
                       <div class="form-group">
                           <label for="pay_on_date" class="col-sm-3 col-xs-3 control-label">ธนาคารต้นทาง:</label>
                           <div class="col-sm-9 col-xs-9">
                               <input type="text" id="" class="form-control input" name="from_bank" placeholder="ใส่ชื่อธนาคารต้นทางที่คุณโอนเงิน">
                           </div>
                       </div>
                       <div class="form-group">
                           <label for="slip_upload" class="col-sm-3 col-xs-3 control-label">หลักฐานการโอน:</label>
                           <div class="col-sm-9 col-xs-9">
                               <input type="file" id="slip_upload" class="form-control input" name="slip_upload">
                           </div>
                       </div>
                    </div>
                   @if(is_null(\Auth::user()->user()->bank_account))
                    <div class="box box-noneborder box-nonepad-top">
                        <div class="box-title font-title">
                            บัญชีธนาคารสำหรับรับเงินคืน
                        </div>
                        <p class="text-indent">คุณจะได้รับเงินคืน ในกรณีที่แคมเปญที่คุณสั่งไม่ได้รับการผลิต</p>
                        <input type="hidden" name="has_bank_account" value="1">
                            <div class="form-group">
                                <label for="name" class="col-sm-3 col-xs-3 control-label">ชื่อบัญชี</label>
                                <div class="col-sm-9 col-xs-9">
                                   <input type="text" class="form-control" id="name" name="name" placeholder="ชื่อเจ้าของบัญชี" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bank_name" class="col-sm-3 col-xs-3 control-label">ชื่อธนาคาร</label>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="เช่น กรุงไทย กสิกรไทย ไทยพาณิชย์" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="branch" class="col-sm-3 col-xs-3 control-label">สาขา</label>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="text" class="form-control" id="branch" name="branch" placeholder="สาขาของธนาคาร" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="no" class="col-sm-3 col-xs-3 control-label">เลขที่บัญชี</label>
                                <div class="col-sm-9 col-xs-9">
                                    <input type="text" class="form-control" id="no" name="no" placeholder="เลขที่บัญชีธนาคาร" required>
                                </div>
                            </div>
                    </div>
                       @endif
                </form>           
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 order-list">
                <div class="box">
                    <div class="box-title font-title">
                        <i class="fa fa-shopping-cart"></i>
                        &nbsp;รายการสินค้า
                    </div>
                    <div class="content">
                        <div class="basket-total">
                            <p><b id="product-name"></b></p>
                            <div class="basket-items row">
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p id="show-transport-cost">
                                        <b>ค่าจัดส่ง: </b>
                                        <span class="pull-right">฿<span>0</span></span>
                                    </p>
                                    <p id="show-card-cost" class="hide">
                                        <b>ค่าการ์ดอวยพร: </b>
                                        <span class="pull-right" id="card-cost-data"> </span>
                                    </p>
                                    <p>
                                        <b>รวมสุทธิ
                                            <span class="pull-right">฿
                                                <span id="total">1</span>
                                            </span>
                                        </b>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="update-transfer" class="col-md-8 col-sm-12 col-xs-12" style="padding-bottom: 25px;">
                <button type="submit" id="update-transfer-btn" class="btn btn-success btn-medium input">แจ้งชำระเงิน</button>
            </div>
    </div>
</div>
</div>
@stop