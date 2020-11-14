@extends('backend.layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('js/timepicker/dist/jquery-ui-timepicker-addon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/new-backend.css') }}">
@stop
@section('script')
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">ของ {{ $user->full_name }} รอบวันที่ {{ $start->format('d/m/Y') }} ถึง {{ $end->format('d/m/Y') }}</h3>
                </div>
                <div class="box-body">
                    <table id="table-manufacture-detail"
                           class="table tablesorter table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th>รหัสสั่งซื้อ</th>
                            <th>ชื่อสินค้า</th>
                            <th>ราคา</th>
                            <th>จำนวน</th>
                            <th>รวม</th>
                            <th>ส่วนแบ่งครีเอเตอร์</th>
                            <th>ส่วนแบ่งนักขาย</th>
                            <th>วันที่</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order_items as $order_item)
                        <tr>
                            <td><a href="{{ action('BackendController@getOrderDetail', $order_item->order_id) }}" target="_blank">{{ $order_item->order_id }}</a></td>
                            <td>
                                <a href="{{ action('CampaignController@showCampaign', $order_item->campaign->url) }}" target="_blank">{{ $order_item->campaign->title }}</a></td>
                            <td>{{ $order_item->price }}</td>
                            <td>{{ $order_item->qty }}</td>
                            <td>{{ $order_item->total() }}</td>
                            <td>{{ $order_item->creatorCommission($user->id) }}</td>
                            <td>{{ $order_item->affiliateCommission($user->affiliate->id) }}</td>
                            <td>{{ $order_item->approved_at->format('d/m/Y') }}</td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="div-pagination">
                        <div class="navbar-right">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop