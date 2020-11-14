@extends('backend.layouts.master')
@section('css')
<link rel="stylesheet" href="{{ asset('js/timepicker/dist/jquery-ui-timepicker-addon.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/new-backend.css') }}">
<style>

</style>
@stop
@section('script')
<script src="{{ asset('js/timepicker/dist/jquery-ui-timepicker-addon.min.js') }}"></script>

<script src="{{ asset('js/timepicker/dist/jquery-ui-sliderAccess.js') }}"></script>
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
            </div>
            <div class="box-body">
                <div class=" form-inline">
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="dataTables_length" id="example1_length">
                                <label>แสดง
                                    <select name="paginate_select" id="paginate-select" class="form-control input-sm">
                                        <option value="{{ action('BackendController@getCommission', 10) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 10 ? 'selected' : '' }}>10</option>
                                        <option value="{{ action('BackendController@getCommission', 25) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 25 ? 'selected' : '' }}>25</option>
                                        <option value="{{ action('BackendController@getCommission', 50) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 50 ? 'selected' : '' }}>50</option>
                                        <option value="{{ action('BackendController@getCommission', 100) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 100 ? 'selected' : '' }}>100</option>
                                    </select> ต่อหน้า
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div id="example1_filter" class="dataTables_filter">
                                <div class="pull-right">
                                    <label>
                                        <form action="{{ action('BackendController@getCommission') }}">
                                            ค้นหา: <input type="text" class="form-control" name="q" placeholder="ค้นหา ชื่อ อีเมล์ หรือ ชื่อผู้ใช้" value="{{ $keyword ? $keyword : '' }}">
                                        </form>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="table-manufacture-detail" class="table tablesorter table-bordered table-striped dataTable">
                    <thead>
                        <tr>
                            <th>ชื่อ-นามสกุล</th>
                            <th>จำนวนเงิน</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="clickable-row" data-href="{{ action('BackendController@getPayoutDetail', $user->id) }}">
                            <td>{{ $user->full_name }}</td>
                            <td>฿{{ number_format(\CommissionService::totalPendingCommission($user), 2) }}</td>
                            <td>รอการตรวจสอบ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="box-footer clear-fix">
                    {!! str_replace('/?', '?', $users->render()) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop