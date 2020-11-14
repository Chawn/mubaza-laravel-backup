@extends('backend.layouts.master')
@section('css')
    <style>
        #table-payment {
            width:100%;
            margin:20px 0 0 0;
        }
        tr.warning {
            background : #fcf8e3;
        }
    </style>
    <script type="text/javascript">
        //  $(function() {
        //         $("table tr:nth-child(odd)").addClass("odd-row");
        // });

        $(function() {
            $(".clickable-row").click(function() {
                window.document.location = $(this).data("href");
            });
        });

        $(document).ready(function() {
            $("#table-payment").tablesorter();
            $("#paginate-select").change(function() {
                window.location = $(this).val();
            });
        });

    </script>

@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                <div class="box-body">
                    <div class=" form-inline">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">
                                <div class="dataTables_length" id="example1_length">
                                    <label>แสดง
                                        <select name="paginate_select" id="paginate-select" class="form-control input-sm">
                                            <option value="{{ action('BackendController@getPayment', 12) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 12 ? 'selected' : '' }}>12 รายการ</option>
                                            <option value="{{ action('BackendController@getPayment', 24) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 24 ? 'selected' : '' }}>24 รายการ</option>
                                            <option value="{{ action('BackendController@getPayment', 36) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 36 ? 'selected' : '' }}>36 รายการ</option>
                                        </select> ต่อหน้า
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <div id="example1_filter" class="dataTables_filter">
                                    <div class="pull-right">
                                        <label>
                                            <form action="{{ action('BackendController@getPayment') }}" method="get">
                                                ค้นหา: <input type="text" class="form-control" name="q" placeholder="" value="{{ $keyword ? $keyword : '' }}">
                                            </form>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table id="table-payment" class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th>รหัสสั่งซื้อ</th>
                            <th>ผู้ซื้อ</th>
                            <th>ยอดโอน</th>
                            <th>วัน-เวลา ที่โอน</th>
                            <th>ธนาคารที่โอนเข้า</th>
                            <th>สถานะการชำระเงิน</th>
                            <th>เครื่องมือ</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)

                                <tr class="{{ $payment->name == 'approve' ? 'warning' : '' }}">
                                <td>
                                    <a href="{{ action('BackendController@getOrderDetail', $payment->order_id) }}">
                                        {{ str_pad($payment->order_id, 6, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ action('BackendController@getUserDetail', $payment->user_id) }}">
                                        {{ $payment->full_name }}
                                    </a>
                                </td>
                                <td>{{ $payment->total }}</td>
                                <td>{{ $payment->created_at }}</td>
                                <td>{{ $payment->to_bank }}</td>
                                <td>{{ $payment->detail }}</td>
                                <td>
                                    <a href="{{ action('BackendController@getPaymentDetail', $payment->id) }}" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">ไม่มีรายการแจ้ง</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="div-pagination">
                        <div class="navbar-right">
{{--                            {!! str_replace('/?', '?', $orders->render()) !!}--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop