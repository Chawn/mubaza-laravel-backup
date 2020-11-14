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

	}); 
</script>
@stop
@section('content')
<div id="manufacture">
	<div id="header-table-manufacture-detail" style="margin:0 0 30px 0">
		<h3>ตรวจสอบการผลิต</h3>
	</div>
    @include('backend.layouts.include.alert')
	<table id="table-manufacture-detail" class="table-radius">
    	<thead>
            <tr>
                <th>หมายเลข</th>
                <th>ชื่อแคมเปญ</th>
                <th>ผู้สร้าง</th>
                <th>วันเริ่ม</th>
                <th>วันจบ</th>
                <th>กำไรจากการขาย</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($campaigns as $campaign)
            <tr class="clickable-row {{ ($campaign->totalProfit() <= config('constant.minimum_profit')) ? 'warning' : '' }}"  data-href="{{ action('BackendController@getShowApprove', $campaign->id) }}"><!-- loop -->
                <td class="col-id">{{ str_pad($campaign->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td class="col-overflow">{{ $campaign->title }}</td>
                <td class="col-name">{{ $campaign->user['full_name'] }}</td>
                <td class="col-time">{{ $campaign->start->format('d-m-Y') }}</td>
                <td class="col-time">{{ $campaign->end->format('d-m-Y') }}</td>
                <td align="right">{{ number_format($campaign->totalProfit(), 2) }}</td>
                <td>{{ $campaign->produce_status->detail }}</td>
            </tr><!--end loop -->
            @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="7">{!! str_replace('/?', '?', $campaigns->render()) !!}
            </td>
        </tr>
        </tfoot>
	</table>
    <div class="clear-fix">&nbsp;</div>
    <div id="header-table-manufacture-detail" style="margin:0 0 30px 0">
        <h3>รายการล่าสุด</h3>
    </div>
    <table class="table table-radius table-hover">
        <thead>
        <tr>
            <th>หมายเลข</th>
            <th>ชื่อแคมเปญ</th>
            <th>ผู้สร้าง</th>
            <th>วันเริ่ม</th>
            <th>วันจบ</th>
            <th>กำไรจากการขาย</th>
            <th>สถานะ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($latest_updates as $campaign)
            <tr class="{{ $campaign->produce_status->name == 'cancel' ? 'danger': '' }}{{ $campaign->produce_status->name == 'waiting' ? 'success' : '' }}" ><!-- loop -->
                <td class="col-id">{{ str_pad($campaign->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td class="col-overflow">{{ $campaign->title }}</td>
                <td class="col-name">{{ $campaign->user['full_name'] }}</td>
                <td class="col-time">{{ $campaign->start->format('d-m-Y') }}</td>
                <td class="col-time">{{ $campaign->end->format('d-m-Y') }}</td>
                <td class="col-name" align="right">{{ number_format($campaign->totalProfit(), 2) }}</td>
                <td class="col-name">{{ $campaign->produce_status->detail }}</td>
            </tr><!--end loop -->
        @endforeach
        </tbody>
    </table>
</div><!-- end manufacture -->
@stop