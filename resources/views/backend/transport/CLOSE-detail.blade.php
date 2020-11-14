@extends('backend.layouts.master')
@section('css')
    <style>
        /* header*/
        #transport-detail {
            margin: 0px 0 0 0;
        }

        #transport-detail img {
            height: 200px;
            width: 200px;
            margin: 10px 0 0 0;
        }

        #transport-detail h6 {
            font-size: 18px;
            padding-bottom: 5px;
        }

        #transport-detail span {
            font-size: 16px;
            vertical-align: text-top;
            display: inline;
        }

        #transport-detail p {
            font-size: 16px;
            vertical-align: text-top;
            color: #000;
            display: inline;
        }

        #transport-detail-header {
            width: 100%;
            display: inline;
        }

        #transport-detail-header h4 {
            font-size: 24px;
            color: #000;
            float: left;
        }

        #transport-detail-header h5 {
            font-size: 24px;
            color: #000;
            float: right;
        }

        #transport-status {
            width: 100%;
            float: right;
            margin: 0 0 10px 0;
            text-align: right;
        }

        #transport-status span {
            font-size: 18px;
            color: #000;
        }

        #transport-status p1 {
            font-size: 18px;
            color: #000;
            vertical-align: middle;
        }

        #transport-status p2 {
            font-size: 18px;
            color: #000;
            vertical-align: middle;
            margin-left: 10px;
        }

        .edit-status {
            color: #2c3e50;
            display: inline;
            font-size: 16px;
            vertical-align: text-top;
            margin: 0 0 0 20px;
        }

        .edit-status:hover {
            text-decoration: none;
            color: #e67e22;
        }

        .edit-status:active {
            text-decoration: none;
            border: 0px solid transparent;
        }

        #collapse-editstatus .well {
            border: 1px solid transparent;
            background: none;
            height: 60px;
        }

        /**/
        #table-transport-detail {
            width: 100%;
            margin: 0 0 20px 0;
            border-top: solid 1px #ddd;
        }

        #table-transport-detail tr {
            line-height: 20px;
            vertical-align: top;
            border-bottom: 1px solid #ddd;
        }

        #table-transport-detail td {
            padding: 15px 0 10px 50px;

        }

        #table-transport-detail tr:last-child {
            padding-bottom: 40px;
            border-bottom: none;
        }

        #btn-download {
            width: 350px;
            height: 40px;
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 15px 0;
        }

        /* Orderstatus (bottom) */
        #btn-printAddressAll {
            width: 250px;
            margin: 0 16px 0 0;
            font-size: 16px;
        }

        #btn-printAddressAll:hover {
        }

        #Receiver {
            margin: 20px 0 50px 0;
        }

        h4 {
            font-size: 22px;
        }

        .pricetag {
            margin: 15px 0 15px 0;
        }

        #pricetag-view-revenue h2 {
            margin: 10px 0 0 0;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#table-receiver").tablesorter();
        });
    </script>
@stop
@section('script')
    <script>
        $(document).ready(function() {
            $('.tracking-no').keyup(function(e) {
                var code = e.which;
                if(code == 13) {
                    saveTrackingNO($(this).val(), $(this).data('url'), $(this));
                }
            });

            $('.edit-btn').click(function() {
                var input = $(this).closest('tr').find('input');
                var disabled = input.attr('disabled');
                if(disabled == 'disabled') {
                    input.removeAttr('disabled');
                    input.focus();
                } else {
                    input.attr('disabled', 'disabled');
                }

            });
            function saveTrackingNO(tracking_no, url, input) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        _token: $('#token').val(),
                        tracking_no: tracking_no
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.result) {
                            if(input.val() != "") {
                                input.attr('disabled', 'disabled');
                            }
                            input.closest('tr').next().find('.tracking-no').focus();
                        }
                        else {
                            alert(data.message);
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
    <div id="transport-detail-header">
        <div class="col-md-5">
            <h4>เลขที่&nbsp;{{ str_pad($campaign->id, 6, '0', STR_PAD_LEFT) }}</h4>
        </div>
        <div class="col-md-7">
            <h5>{{ $campaign->title }}</h5><br/><br/>
        </div>
    </div><!-- end transport-detail-header -->
    <div id="transport-detail">
        <div class="col-md-12">
            <input name="_token" type="hidden" id="token" value="{{ csrf_token() }}"/>
            @foreach($ordered_product['items'] as $product)
                <div class="produce-detail-sold-box">
                    <div class="produce-detail-sold-icon">
                        <img src="{{ asset('images/icon/icon-t-shirt.png') }}">
                    </div>
                    <div class="produce-detail-sold-right">
                        <h3 class="product-type">{{ $product['name']  }}</h3>
                        <table class="table table-produce-detail-sold">
                            <thead>
                            <tr>
                                <th></th>
                                @foreach(explode(',', $product['available_size']) as $size)
                                    <th>{{ $size }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($product['colors'] as $key => $color)
                                <tr>
                                    <td>{{ $key }}</td>
                                    @foreach(explode(',', $product['available_size']) as $size)
                                        <td>{{ isset($color['sizes'][$size]) ? $color['sizes'][$size] : '0' }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div> <!-- end order-detail -->

    <div class="row">
        <div class="col-md-12">
            <div id="Receiver">
                <div class="navbar-left"><h4>รายชื่อผู้สั่งซื้อ</h4></div>
                <div class=" navbar-right"><a id="btn-printAddressAll" class="btn btn-success"
                                              href="http://localhost/mubaza/public/backend-print-customer-address"><i
                                class="fa fa-print"></i> พิมพ์ที่อยู่ผู้รับทั้งหมด </a><a class="btn btn-default"
                                                                                          href="{{ action('BackendController@getSetTransported', $campaign->id) }}">บันทึกสถานะการจัดส่ง</a>
                </div>
                <table id="table-receiver" class="table-radius">
                    <thead>
                    <tr>
                        <th width="5%">ลำดับ</th>
                        <th width="15%">ชื่อ - สกุล</th>
                        <th width="10%">เบอร์โทร</th>
                        <th width="35%">ที่อยู่ผู้รับ</th>
                        <th width="10%">Tracking NO</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        @if($order->shipping_address)
                            <tr>
                                <td>{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $order->shipping_address->full_name }}</td>
                                <td>{{ $order->shipping_address->phone }}</td>
                                <td>{{ $order->shipping_address->address }}&nbsp;อ.{{ $order->shipping_address->district }}
                                    จ.{{ $order->shipping_address->province }}</td>
                                <td width="15%">

                                    <div class="input-group">
                                        <input type="text" name="tracking_no"
                                               placeholder="Tracking NO"
                                               data-url="{{ action('BackendController@postSaveTrackingNO', $order->shipping_address->id) }}"
                                               value="{{ $order->shipping_address->tracking_no }}"
                                               {{ $order->shipping_address->tracking_no === '' ? '' : 'disabled' }}
                                               class="form-control tracking-no"/>
                                          <span class="input-group-btn">
                                              <button class="btn btn-default edit-btn" type="button">แก้ไข</button>
                                          </span>
                                    </div><!-- /input-group --></td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <div class="div-pagination">
                    <div class="navbar-right">
                        {!! str_replace('/?', '?', $orders->render()) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tracking-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">กรุณากรอกหมายเลขแทรกกิ้ง ของคุณปรียานุช</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">หมายเลข:</label>
                                <input type="text" class="form-control" id="recipient-name">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-green">ยืนยัน</button>
                    </div>
                </div>
            </div>
        </div>

@stop