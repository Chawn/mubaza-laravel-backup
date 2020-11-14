@extends('backend.layouts.master')
@section('css')

<script type="text/javascript">
	$(document).ready(function() { 
		$("#table-sale-detail").tablesorter(); 
	}); 
</script>
@stop
@section('content')
<div id="sale">
	<div id="header-table-saledetail" style="margin:0px 0 30px 0">
		<h3>การขาย</h3>
		<div class="btn-group navbar-right" style=" margin-right:5px">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">แคมเปญยังไม่จบ<span class="caret"></span></button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">แคมเปญยังไม่จบ</a></li>
						<li><a href="#">แคมเปญจบแล้ว</a></li> 
						<li><a href="#">แคมเปญปิด</a></li>
					</ul>         
		</div>
	</div>             
	<table id="table-sale-detail" class="table-radius">
    	<thead>
            <tr>
                <th width="10%">หมายเลข</th>
                <th width="30%">ชื่อแคมเปญ</th>
                <th width="10%">ผู้สร้าง</th>
                <th width="10%">วันเริ่ม</th>
                <th width="10%">วันจบ</th>
                <th width="15%">เป้าหมาย/จำนวนผู้ซื้อ</th>
                <th width="15%">สถานะแคมเปญ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($campaigns as $campaign)
                <tr class="clickable-row" data-href="http://localhost/mubaza/public/backend-sale-detail">
                    <td>{{ str_pad($campaign->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $campaign->title }}</td>
                    <td>{{ $campaign->user ? $campaign->user->full_name : '-' }}</td>
                    <td>{{ $campaign->start->format('d/m/Y') }}</td>
                    <td>{{ $campaign->end->format('d/m/Y') }}</td>
                    <td>123/234</td>
                    <td>{{ $campaign->status->name }}</td>
                </tr>
            @endforeach
        </tbody>
	</table>
	<div class="div-pagination">
		<div class="navbar-left">
       		<p>แสดง 10 จาก 109</p>
      	</div>
  		<div class="navbar-right">
       		<div class="a-pagination">
            	<a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>   
              	<a href="#">1</a>
              	<a href="#">2</a>
               	<a href="#">3</a>
              	<a href="#">4</a>
               	<a href="#">5</a>
                <a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
			</div>
    	</div>
	</div><!-- end div-pagination -->
</div><!-- end sale -->
@stop