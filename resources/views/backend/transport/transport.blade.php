@extends('backend.layouts.master')
@section('css')
    <style>

        #table-manufacture-detail h3 {
            display:inline;
        }
        #table-manufacture-detail h2 {
            font-size:14px;
            color:#666;
        }
        #table-manufacture-detail>tbody>tr>td:nth-child(2){
            text-align: left;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#table-manufacture-detail").tablesorter();
            $('.clickable-row td:not(:last-child)').click(function() {
                window.document.location = $(this).data("href");
            });
            $("#paginate-select").change(function() {
                window.location = $(this).val();
            });
        });
    </script>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title"></h3>
                <div class=" form-inline">
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="dataTables_length" id="example1_length">
                                <label>แสดง
                                    <select name="example1_length" id="paginate-select" class="form-control input-sm">
                                        <option value="{{ action('BackendController@getTransport', 10) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 10 ? 'selected' : '' }}>10</option>
                                        <option value="{{ action('BackendController@getTransport', 20) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 20 ? 'selected' : '' }}>20</option>
                                        <option value="{{ action('BackendController@getTransport', 30) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 30 ? 'selected' : '' }}>30</option>
                                    </select> รายการ
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div id="example1_filter" class="dataTables_filter">
                                <div class="pull-right">
                                    <label>
                                        <form action="">
                                            ค้นหา: <input type="text" class="form-control" name="q" placeholder="" value="{{ $keyword != '' ? $keyword : '' }}">
                                        </form>
                                    </label>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ action('BackendController@getCampaign') }}">ทั้งหมด</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body box-product">
                <table class="table">
                    <thead>
                        <tr>
                            <th>วันที่จัดส่ง</th>
                            <th>รายการสั่งซื้อ</th>
                            <th>ชื่อผู้รับ</th>
                            <th>วิธีการจัดส่ง</th>
                            <th>Tracking No.</th>
                            <th>เครื่องมือ</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->shipping_address->updated_at->format('d/m/Y') }}</td>
                            <td>#{{ str_pad($order->id, 6, 0, STR_PAD_LEFT) }}</td>
                            <td>{{ $order->shipping_address->full_name }}</td>
                            <td>{{ $order->shipping_type->detail }}</td>
                            <td>{{ $order->shipping_address->tracking_code }}</td>
                            <td>
                                <a href="{{ action('BackendController@getOrderDetail', $order->id) }}" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </a>
                                <a href="{{ action('BackendController@getShippingDetail', $order->id) }}" class="btn btn-warning">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="div-pagination">
                    <div class="navbar">
                        {!! str_replace('/?', '?', $orders->render()) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop