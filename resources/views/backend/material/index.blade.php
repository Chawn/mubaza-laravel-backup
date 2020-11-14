@extends('backend.layouts.master')
@section('css')
<style>

</style>
<script type="text/javascript">
	$(document).ready(function() { 
		

	}); 
</script>
@stop
@section('content')
<div id="manufacture">
	<div id="header-table-manufacture-detail" style="margin:0px 0 30px 0">
		<h3>วัสดุอุปกรณ์</h3>
	</div>
	<table id="table-manufacture-detail" class="table-radius">
    	<thead>
            <tr>
                <th width="10%">รหัส</th>
                <th width="30%">ชื่อ</th>
                <th width="10%">คำอธิบาย</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $material)
            <tr class="clickable-row" data-href="{{ action('BackendController@getShowProduce', $campaign->id) }}"><!-- loop -->
                <td>{{ str_pad($campaign->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $campaign->title }}</td>
                <td>{{ $campaign->user->full_name }}</td>
            </tr><!--end loop -->
            @endforeach
        </tbody>
	</table>
        {!! str_replace('/?', '?', $campaigns->render()) !!}
</div><!-- end manufacture -->
@stop