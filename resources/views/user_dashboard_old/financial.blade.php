@extends('layouts.user_full_width')
@section('css')
<style>
#overview a {
	color:#999;
	}
#table-overview {
	width: 100%;
	text-align:center;	
    }
#table-overview tr {
	}
#table-overview td {
	width:30%;
	padding: 10px 0 10px 0;
	}
#table-overview li {
	list-style:none;
	display:inline;
	text-align:center;
	margin: 0 15px 0 0;
	}

#campaing-detail p {
	font-size:16px;
	display:inline;
	margin-right:5px;
	}
#campaing-detail span {
	font-size:10px;
	color:#999;
	}
#campaing-detail a {
	color:#111;
	margin-right:15px;
	}
#table-campaing-detail {
	width:100%;
	text-align:center;
	display:inline;
	}
#table-campaing-detail th {
	height:50px;
	padding-bottom:15px;
	}
#table-campaing-detail tr {
	height:70px;
	}
#table-campaing-detail td:first-child {
	width:10%;
	}
#table-campaing-detail td:last-child {
	width:10%;
	}
#table-campaing-detail td {
	width:20%;
	}
#profit-collapse td {
	width:25%;
	}
#table-campaing-detail .odd-row td{
	background:#f8f8f8;
	}
select {
	border: 1px solid transparent;
	}
</style>

<script>
$(document).ready(function(){
    
    
		$("#profit-collapse").hide();
        $("#a-profit").click(function () {
			$("#profit-collapse").show("slow");
			$("#profit-click-hide").hide();
        });
		$("#a-profit-collapse").click(function () {
			$("#profit-collapse").hide();
			$("#profit-click-hide").show("slow");
        });
		$("#a-profit-collapse2").click(function () {
			$("#profit-collapse").hide();
			$("#profit-click-hide").show("slow");
        });
    
	
	
      $('[data-toggle="tooltip"]').tooltip();
   


        /* For zebra striping */
        $("table tr:nth-child(odd)").addClass("odd-row");

});

</script>

@stop
@section('content')
<div id="user-dashboard">
    <div class="content">
        <div class="container ">
            <div id="user-setting">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>เลขที่</th>
                                    <th>รายการ</th>
                                    <th>สถานะ</th>
                                    <th>แคมเปญ</th>
                                    <th>จำนวนเงิน</th>
                                    <th>วันที่</th>
                                    <th>บัญชีธนาคาร</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payouts as $payout)
                                <tr>
                                    <td>
                                        @if($payout->type->name == 'refund')
                                            {{ is_null($payout->order_id) ? '-' : str_pad($payout->order->id, 6, 0, STR_PAD_LEFT) }}
                                        @elseif($payout->type->name == 'profit')
                                            #{{ str_pad($payout->campaign->id, 6, 0, STR_PAD_LEFT) }}
                                        @endif
                                    </td>
                                    <td>{{ $payout->type->detail }}</td>
                                    <td>
                                        {{ $payout->status->detail }}
                                    </td>
                                    <td>{{ $payout->campaign->title }}</td>
                                    <td>
                                        @if($payout->type->name == 'refund')
                                            {{ is_null($payout->order) ? '-' : '฿' . number_format($payout->order->payment->first()->total, 2) }}
                                        @elseif($payout->type->name == 'profit')
                                            {{ is_null($payout->campaign) ? '-' : '฿' . number_format($payout->campaign->totalProfit(), 2) }}
                                        @endif
                                    </td>
                                    <td>{{ (is_null($payout->transferred_on)) ? '-' : $payout->transferred_on->format('d/m/Y H:i') }}</td>
                                    <td>{{ $payout->bank_name }}&nbsp;{{ $payout->bank_no }}</td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">ไม่พบรายการประวัติการเงิน</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                     </div>
                     <div class="col-md-12">
                         {!! str_replace('/?', '?', $payouts->render()) !!}
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop