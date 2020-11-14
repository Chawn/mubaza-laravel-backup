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

        #table-manufacture-detail tbody > tr > td:nth-child(2) {
            text-align: left;
        }

    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#table-waitting").tablesorter();
        });
    </script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.include.alert')
            @foreach($orders as $order)
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">
                            รายการสั่งซื้อ: <a href="{{ action('BackendController@getOrderDetail', $order->id) }}">
                                #{{ $order->id }}
                            </a> 
                        </h3>

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
                            <div class="col-sm-6">
                                <a href="{{ action('BackendController@getOrderDetail', $order->id) }}"
                                   class="btn btn-primary">
                                    <strong>
                                        <i class="fa fa-search"></i> รายละเอียด
                                    </strong>
                                </a>
                                <a href="{{ action('BackendController@getPrintCustomerAddress', $order->id) }}"
                                   class="btn btn-default-shadow">
                                    <i class="fa fa-print"></i>
                                    พิมพ์ใบปะหน้าที่อยู่
                                </a>
                            </div>
                            <div class="col-sm-6 text-right">
                                <form action="{{ action('BackendController@getSetShipped', $order->id) }}"
                                      method="get">
                                    <div class="input-group input-tracking">
                                        <input type="text" class="form-control" name="tracking_code"
                                               placeholder="ใส่ Tracking ที่นี่"
                                               value="{{ $order->shipping_address->tracking_code }}" required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-truck"></i>
                                    จัดส่งแล้ว
                                    <i class="fa fa-check"></i>
                                </button>
                                </span>
                                    </div>
                                </form>
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