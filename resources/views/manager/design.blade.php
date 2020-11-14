@extends('manager.layouts.master')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script>
    </script>
@stop
@section('css')
    <style type="text/css" media="screen">
        .product-img img {
            max-width: 100px;
        }
    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <table class="table table-bordered table-hover table-flex dataTable text-center">
                <thead>
                <tr>
                    <th>รูปสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>รหัสสินค้า</th>
                    <th>ราคา</th>
                    <th>สถานะ</th>
                    <th>เครื่องมือ</th>
                </tr>
                </thead>
                <tbody>
                @forelse($campaigns as $campaign)
                    <tr>
                        <td data-label="รูปสินค้า">
                            <div class="product-img">
                                <img src="{{ action('CampaignController@getFile', [$campaign->id, $campaign->frontCover()]) }}">
                            </div>
                        </td>
                        <td data-label="ชื่อสินค้า">
                            {{ $campaign->title }}
                        </td>
                        <td data-label="รหัสสินค้า">
                            {{ str_pad($campaign->id, 6, 0, STR_PAD_LEFT) }}
                        </td>
                        <td data-label="ราคา">
                            ฿{{ $campaign->products->first()->sell_price }}
                        </td>
                        <td data-label="สถานะ">
                            <p class="{{ ($campaign->status->name=='close') ? 'text-red' : '' }} {{ ($campaign->status->name=='open') ? 'text-green' : '' }} ">
                                {{ $campaign->status->detail }}
                            </p>

                        </td>
                        <td data-label="เครื่องมือ">
                            <a href="{{ action('AssociateController@getEditCampaign', $campaign->id) }}"
                               class="btn btn-default">
                                <i class="fa fa-pencil"></i> แก้ไข
                            </a>
                            <a href="{{ url('/') . '/'. $campaign->url .'.html' }}"
                               target="_blank" class="btn btn-default btn-bright">
                                <i class="fa fa-search"></i> หน้าแสดงสินค้า
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">ไม่มีรายการสินค้า</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">{!! str_replace('/?', '?', $campaigns->render()) !!}</td>
                    </tr>
                </tfoot>
            </table>
        
        </div>
    </div>
@stop