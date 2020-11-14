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
        <div class="col-md-9">
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
                                            <option value="{{ action('BackendController@getMonthlyCommission', 10) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 10 ? 'selected' : '' }}>10</option>
                                            <option value="{{ action('BackendController@getMonthlyCommission', 25) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 25 ? 'selected' : '' }}>25</option>
                                            <option value="{{ action('BackendController@getMonthlyCommission', 50) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 50 ? 'selected' : '' }}>50</option>
                                            <option value="{{ action('BackendController@getMonthlyCommission', 100) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 100 ? 'selected' : '' }}>100</option>
                                        </select> ต่อหน้า
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <div id="example1_filter" class="dataTables_filter">
                                    <div class="pull-right">
                                        <label>
                                            <form action="{{ action('BackendController@getMonthlyCommission') }}">
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
                            <th>ชื่อสินค้า</th>
                            <th>วันที่เริ่มต้น</th>
                            <th>วันที่สิ้นสุด</th>
                            <th>จำนวนเงิน</th>
                            <th>สถานะ</th>
                            {{--<th>&nbsp;</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                                <tr class="clickable-row" data-href="{{ action('BackendController@getMonthlyCommissionDetail', $user->id) }}">
                                <td>{{ $user->full_name }}</td>
                                <td>{{ \Carbon::now()->subMonth()->startOfMonth()->format('d/m/Y') }}</td>
                                <td>{{ \Carbon::now()->subMonth()->endOfMonth()->format('d/m/Y') }}</td>
                                <td>฿{{ number_format(\CommissionService::sumCommission($user,
                                \Carbon::now()->subMonth()->startOfMonth(),
                                \Carbon::now()->subMonth()->endOfMonth()), 2) }}</td>
                                    <td>รอการตรวจสอบ</td>
                                    {{--<td><a href="{{ action('BackendController@getMonthlyCommissionApprove', $user->id) }}" class="btn btn-success" title="ยืนยัน"><i class="fa fa-check"></i></a></td>--}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="box-footer clear-fix">
                        {!! str_replace('/?', '?', $users->render()) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        เครื่องมือ
                    </div>
                </div>
                <div class="box-body">
                    <a href="{{ action('BackendController@getMonthlyCommissionApprove') }}" class="btn btn-success {{ (\Carbon::now()->day >= 16) ? '' : 'disabled'}}">
                        <i class="fa fa-check"></i>
                        อนุมติทั้งหมด
                    </a>
                    <p>กดอนุมัติทุกวันที่ 16 ของทุกเดือน</p>
                </div>
            </div>
            
        </div>
    </div>
@stop