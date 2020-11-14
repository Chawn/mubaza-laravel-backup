@extends('layouts.full_width')
@section('script')
<script>
    $(document).ready(function () {
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

        $('#order-id').keyup(function(e) {
            $('.input').attr('disabled', 'disabled');
            var code = e.which;
            if(code == 13) {
                $('#check-order-id').trigger('click');
            }
        });
        $('#check-order-id').click(function() {
            var order_id = $('#order-id');
            var $btn = $(this).button('loading');

            if(order_id.val() != '') {
                $.ajax({
                    type: "GET",
                    url: $(this).data('url') + '/' + order_id.val(),
                    dataType: "json",
                    success: function (data) {
                        if (!data.error) {
                            $('.input').removeAttr('disabled');
                            $('.input:first').focus();
                        }
                        else {
                            alert(data.message);
                            $('.input').attr('disabled', 'disabled');
                            order_id.focus();
                        }

                        $btn.button('reset');
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }
        });
    });
</script>
@stop
@section('css')
<style type="text/css" media="screen">
    .input-time{
        max-width: 70px!important;
    }
</style>
@stop
@section('content')
<div id="page-informpayment" class="container ">
    <div class="row">
        <div class="col-md-12 ">
           <h1>แจ้งชำระเงิน</h1>
            Errors : {{ dd($messages) }}
        @if($messages)
            @endif
           <form class="form-horizontal" action="{{ action('OrderController@postUpdateTransfer') }}" method="post" accept-charset="utf-8">
               <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
               <table class="table-form">
                    <tr>
                        <td>รหัสสั่งซื้อ: </td>
                        <td>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <input type="number" id="order-id" class="form-control" name="order_id" value="{{ $order_id }}">
                                </div>
                                <a href="javascript:void(0)" class="btn btn-success col-sm-3"
                                        id="check-order-id" data-url="{{ action('OrderController@getCheckOrderClosed') }}">
                                    <i class="fa fa-search"></i>&nbsp;ตรวจสอบ</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>ยอดเงินที่โอน: </td>
                        <td>
                            <input type="number" id="" class="form-control input" disabled="disabled" name="total">
                        </td>
                    </tr>
                    <tr>
                        <td>หมายเลขอ้างอิง: </td>
                        <td>
                            <input type="text" id="" class="form-control input" disabled="disabled" name="transaction_id">
                        </td>
                    </tr>
                    <tr>
                        <td>วันที่โอน: </td>
                        <td>
                            <input type="text" id="pay_on_date" class="form-control input" disabled="disabled" name="pay_on_date">
                        </td>
                    </tr>
                    <tr>
                        <td>เวลา:</td>
                        <td>
                            <div class="col-md-3">
                                <select class="form-control input" disabled="disabled" name="hour" id="hour">
                                    @for($i = 1; $i < 25; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control input" disabled="disabled" name="minute" id="minute">
                                    @for($i = 1; $i <= 60; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>ธนาคารที่โอนเข้า: </td>
                        <td>
                            <label class="bank-item">
                                <input type="radio" class="input" disabled="disabled" name="to_bank" value="ธนาคารกรุงเทพ">
                                <div class="bank-img column">
                                    <img src="{{ asset('images/icon/bangkok-bank.jpg') }}">
                                </div>
                                <div class="bank-detail column">
                                   <b>ธนาคารกรุงเทพ สาขาเซ็นทรัลพลาซ่า อุดรธานี</b>
                                    <br>ชื่อบัญชี: นายชาวพุทธ นวกาลัญญู
                                    <br>เลขที่บัญชี: 431-0-46801-2
                                </div>
                            </label>
                            <br>
                            <label class="bank-item">
                                <input type="radio" class="input" disabled="disabled" name="to_bank" value="ธนาคารกรุงไทย">
                                <div class="bank-img column">
                                    <img src="{{ asset('images/icon/ktb.jpg') }}">
                                </div>
                                <div class="bank-detail column">
                                   <b>ธนาคารกรุงไทย สาขาเซ็นทรัลพลาซ่า อุดรธานี</b>
                                    <br>ชื่อบัญชี: นายชาวพุทธ นวกาลัญญู
                                    <br>เลขที่บัญชี: 431-0-46801-2
                                </div>
                            </label>
                            <br>
                            <label class="bank-item">
                                <input type="radio" class="input" disabled="disabled" name="to_bank" value="ธนาคารกสิกรไทย">
                                <div class="bank-img column">
                                    <img src="{{ asset('images/icon/kbank.jpg') }}">
                                </div>
                                <div class="bank-detail column">
                                   <b>ธนาคารกสิกรไทย สาขาเซ็นทรัลพลาซ่า อุดรธานี</b>
                                    <br>ชื่อบัญชี: นายชาวพุทธ นวกาลัญญู
                                    <br>เลขที่บัญชี: 431-0-46801-2
                                </div>
                            </label>
                            <br>
                            <label class="bank-item">
                                <input type="radio" class="input" disabled="disabled" name="to_bank" value="ธนาคารไทยพาณิชย์">
                                <div class="bank-img column">
                                    <img src="{{ asset('images/icon/siamcommercial-bank.jpg') }}">
                                </div>
                                <div class="bank-detail column">
                                   <b>ธนาคารไทยพาณิชย์ สาขาเซ็นทรัลพลาซ่า อุดรธานี</b>
                                    <br>ชื่อบัญชี: นายชาวพุทธ นวกาลัญญู
                                    <br>เลขที่บัญชี: 431-0-46801-2
                                </div>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>ธนาคารต้นทาง: </td>
                        <td>
                            <input type="text" id="" class="form-control input" disabled="disabled" name="from_bank" placeholder="ใส่ชื่อธนาคารต้นทาง">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                           <button type="submit" id="update-transfer-btn" disabled="disabled" class="btn btn-success input">แจ้งชำระเงิน</button>
                        </td>
                    </tr>
               </table>
           </form>
           
        </div>
    </div>
</div>
@stop