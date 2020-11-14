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

            $('#transport-detail-form').validate({
                errorPlacement: function (error, element) {
                    // Append error within linked label
                    $(element).addClass('error');
                }
            });

            $('#save-btn').click(function () {
                if ($('#transport-detail-form').valid()) {
                    $('#transport-detail-form').submit();
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
                        รายละเอียดการจัดส่ง หมายเลขสั่งซื้อ: <a
                                href="{{ action('BackendController@getOrderDetail', $order->id) }}">#{{ str_pad($order->id, 6, 0, STR_PAD_LEFT) }}</a>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="col-sm-8">
                        <form action="{{ action('BackendController@postUpdateShippingDetail', $order->id) }}" method="post" id="transport-detail-form">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="full-name">ชื่อผู้รับ</label>
                                <input type="text" name="full_name" id="full-name" class="form-control"
                                       placeholder="ชื่อผู้รับ" value="{{ $order->shipping_address->full_name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="address">ที่อยู่</label>
                                <input type="text" name="address" id="address" class="form-control"
                                       placeholder="ที่อยู่" value="{{ $order->shipping_address->address }}" required>
                            </div>
                            <div class="form-group">
                                <label for="district">เขต/อำเภอ</label>
                                <input type="text" name="district" id="district" class="form-control"
                                       placeholder="เขต/อำเภอ" value="{{ $order->shipping_address->district }}" required>
                            </div>
                            <div class="form-group">
                                <label for="province">จังหวัด</label>
                                <select name="province" id="province" class="form-control"
                                        required>
                                    @foreach(Config::get('constant.provinces') as $province)
                                        <option value="{{ $province }}" {{ $province == $order->shipping_address->province ? 'selected' : '' }}>
                                            {{ $province }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="zipcode">รหัสไปรษณีย์</label>
                                <input type="text" name="zipcode" id="zipcode" class="form-control"
                                       placeholder="รหัสไปรษณีย์" value="{{ $order->shipping_address->zipcode }}" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">หมายเลขโทรศัพท์</label>
                                <input type="tel" name="phone" id="phone" class="form-control"
                                       placeholder="หมายเลขโทรศัพท์" value="{{ $order->shipping_address->phone }}" required>
                            </div>
                            <div class="form-group">
                                <label for="tracking-code">Tracking code</label>
                                <input type="text" name="tracking_code" id="tracking-code" class="form-control"
                                       placeholder="Tracking code" value="{{ $order->shipping_address->tracking_code }}" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">เครื่องมือ</div>
                </div>
                <div class="box-body">
                    <button class="btn btn-success btn-block" id="save-btn">
                        <i class="fa fa-check"></i> บันทึก
                    </button>
                    <a href="{{ action('BackendController@getTransport') }}" class="btn btn-warning btn-block">
                        <i class="fa fa-times"></i> ยกเลิก
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop