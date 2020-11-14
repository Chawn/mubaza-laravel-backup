@extends('backend.layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('js/timepicker/dist/jquery-ui-timepicker-addon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/new-backend.css') }}">
@stop
@section('script')
    <script>
        $(document).ready(function() {
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
                    <div class="box-tool">

                    </div>
                </div>
                <div class="box-body">
                    <div class=" form-inline">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">
                                <div class="dataTables_length" id="example1_length">
                                    <label>แสดง
                                        <select name="paginate_select" id="paginate-select" class="form-control input-sm">
                                            <option value="{{ action('BackendController@getMonthlyCommissionHistory', 10) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 10 ? 'selected' : '' }}>10</option>
                                            <option value="{{ action('BackendController@getMonthlyCommissionHistory', 25) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 25 ? 'selected' : '' }}>25</option>
                                            <option value="{{ action('BackendController@getMonthlyCommissionHistory', 50) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 50 ? 'selected' : '' }}>50</option>
                                            <option value="{{ action('BackendController@getMonthlyCommissionHistory', 100) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 100 ? 'selected' : '' }}>100</option>
                                        </select> ต่อหน้า
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <div id="example1_filter" class="dataTables_filter">
                                    <div class="pull-right">
                                        <label>
                                            <form action="{{ action('BackendController@getMonthlyCommissionHistory') }}">
                                                ค้นหา: <input type="text" class="form-control" name="q" placeholder="ค้นหา ชื่อ อีเมล์ หรือ ชื่อผู้ใช้" value="{{ $keyword ? $keyword : '' }}">
                                            </form>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <table id="table-manufacture-detail"
                               class="table tablesorter table-bordered table-striped dataTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>ชื่อสินค้า</th>
                                <th>วันที่เริ่มต้น</th>
                                <th>วันที่สิ้นสุด</th>
                                <th>จำนวนเงิน</th>
                                <th>สถานะ</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($monthly_commissions as $monthly_commission)
                                <tr class="clickable-row" data-href="{{ action('BackendController@getMonthlyCommissionDetail', [$monthly_commission->user->id, $monthly_commission->id]) }}">
                                    <td>{{ $monthly_commission->id }}</td>
                                    <td>{{ $monthly_commission->user->full_name }}</td>
                                    <td>{{ $monthly_commission->start->format('d/m/Y') }}</td>
                                    <td>{{ $monthly_commission->end->format('d/m/Y') }}</td>
                                    <td>฿{{ number_format($monthly_commission->total, 2) }}</td>
                                    <td>{{ $monthly_commission->status->detail }}</td>
                                    <td><a href="" class="btn btn-warning" title="ยืนยัน"><i class="fa fa-times"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer clear-fix">
                        {!! str_replace('/?', '?', $monthly_commissions->render()) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop