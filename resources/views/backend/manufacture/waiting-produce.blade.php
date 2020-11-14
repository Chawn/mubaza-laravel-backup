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

        .product-item img {
            width: 150px;
        }

        .art-image {
            width: 100px;
        }

        .small-product-image {
            width: 140px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>
@stop
@section('content')
    <div class="row">
        @include('backend.layouts.include.alert')
        @if(count($orders)<1)
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-body">
                        <h3>
                            <i class="fa fa-coffee"></i> ขณะนี้ยังไม่มีสินค้ารอดำเนินการผลิต
                        </h3>
                    </div>
                </div>
            </div>
        @endif
        @foreach($orders as $order)
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">
                            รายการสั่งซื้อ: #{{ str_pad($order->id, 6, 0, STR_PAD_LEFT) }}
                        </h3>

                        <div class="pull-right">
                            <span class="badge alert-danger">เหลือเวลา {{ $order->remainDay() }} วัน</span>
                        </div>
                    </div>
                    <div class="box-body box-product">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อสินค้า</th>
                                <th><span class="text-info">ลายด้านหน้า</span></th>
                                <th><span class="text-info">รูปเสื้อด้านหน้า</span></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($order->items as $key => $item)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        {{ $item->sku->color->product->name }}
                                        <br>{{ $item->sku->size }}
                                        <br>{{ $item->qty }} ตัว
                                    </td>
                                    <td>
                                        @if($item->campaign->image_front != null)
                                        <img class="art-image" src="{{ action('CampaignController@getFile', [$item->campaign->id, $item->campaign->image_front]) }}">
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->campaign->image_front != null)
                                        <img class="small-product-image" src="{{ action('CampaignController@getFile', [$item->campaign->id, $item->campaign_product->image_front]) }}">
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">ไม่มีสินค้า</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{ action('BackendController@getOrderDetail', $order->id) }}" class="btn btn-primary">
                                    <strong>
                                        <i class="fa fa-search"></i> รายละเอียด
                                    </strong>
                                </a>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="{{ action('BackendController@getCancelProduce', $order->id) }}" class="btn btn-warning">
                                    <i class="fa fa-times"></i>
                                    ปฏิเสธการผลิต
                                </a>
                                <a href="{{ action('BackendController@getSetProducing', $order->id) }}" class="btn btn-success">
                                    <i class="fa fa-chevron-circle-right"></i>
                                    ดำเนินการผลิต
                                </a>
                            </div>
                        </div>


                        <div class="div-pagination">
                            <div class="navbar-right">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@stop