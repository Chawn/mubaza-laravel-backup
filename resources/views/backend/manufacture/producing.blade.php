@extends('backend.layouts.master')
<link rel="stylesheet" href="{{ asset('css/new-backend.css') }}">
@section('css')
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

        @media print {
            body * {
                visibility: hidden;
            }

            #section-to-print, #section-to-print * {
                visibility: visible;
            }

            #section-to-print {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
@stop
@section('script')
    <script>
        $(document).ready(function () {
            $('.download-campaign-art-button').click(function () {
                element = $(this);
                $.ajax({
                    type: "GET",
                    url: "/backend/campaign-art/" + element.data("campaign-id"),
                    dataType: "json",
                    success: function (data) {
                        if (!data.error) {
                            document.location = data.file_url;
                        } else {
                            alert(data.message);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            });
            $('.download-order-art-button').click(function () {
                element = $(this);
                $.ajax({
                    type: "GET",
                    url: "/backend/order-art/" + element.data("order-id"),
                    dataType: "json",
                    success: function (data) {
                        if (!data.error) {
                            document.location = data.file_url;
                        } else {
                            alert(data.message);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            });
            $('.finish-checkbox').click(function () {
                var element = $(this);
                if(confirm("ยืนยันการบันทึกข้อมูล")) {
                    var item_id = element.data("item-id");
                    $.ajax({
                        type: "GET",
                        url: "/backend/item-produced/" + item_id,
                        dataType: "json",
                        success: function (data) {

                        },
                        failure: function (errMsg) {
                            alert(errMsg);
                        }
                    });
                } else {
                    element.prop("checked", false);
                }
            });
        });
    </script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">รายการสินค้าที่ต้องใช้ในการผลิต</h3>
                </div>
                <div class="box-body box-product">
                    @foreach($prepare_shirt as $shirt)
                        <strong>{{ $shirt['product_name'] }}</strong>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th width="28%">สี</th>
                            @foreach(config('constant.available_sizes') as $size)
                                <th>{{ $size }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shirt['colors'] as $color)
                        <tr>
                            <td>{{ $color['color_name'] }}</td>
                            @foreach(config('constant.available_sizes') as $size)
                            <td>{{ isset($color[$size]) ? $color[$size] : '' }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                        <br>
                        @endforeach
                </div>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.include.alert')
                @foreach($orders as $order)
                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">รายการสั่งซื้อ: <a
                                        href="{{ action('BackendController@getOrderDetail', $order->id) }}">#{{ str_pad($order->id, 6, 0, STR_PAD_LEFT) }}</a></h3>

                            <div class="pull-right">
                                <span class="badge alert-danger">เหลือเวลา {{ $order->remainDay() }} วัน</span>
                            </div>
                        </div>
                        <div class="box-body box-product">
                            <div class="row">
                                @foreach($order->items as $item)
                                    <div class="col-sm-2">
                                        @include('backend.layouts.include.product-box-produce',['item' => $item])
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <button class="btn btn-default-shadow download-order-art-button"
                                            data-order-id="{{ $order->id }}">
                                        <i class="fa fa-download"></i>
                                        ดาวน์โหลด Art ทั้งหมด

                                    </button>
                                    <a href="{{ action('BackendController@getPrintCustomerAddress', $order->id) }}"
                                       class="btn btn-default-shadow">
                                        <i class="fa fa-print"></i>
                                        พิมพ์ใบปะหน้าที่อยู่
                                    </a>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <a href="{{ action('BackendController@getSetProduced', $order->id) }}"
                                       class="btn btn-success">
                                        <i class="fa fa-cubes"></i>
                                        ผลิตเสร็จแล้ว
                                        <i class="fa fa-check"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="div-pagination">
                                <div class="navbar-right">

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
@stop