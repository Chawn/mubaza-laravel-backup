@extends('layouts.full_width')
@section('css')
<style>
#table-order-history {
	width: 100%;

	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;

	-moz-box-shadow: 0 1px 2px #d1d1d1;
	-webkit-box-shadow: 0 1px 2px #d1d1d1;
	box-shadow: 0 1px 2px #d1d1d1;

    }
#table-order-history tr {
	border-bottom:1px solid #f9f9f9;
	border-left:1px solid #f9f9f9;
	border-right:1px solid #f9f9f9;
	height:50px;
	}
#table-order-history thead tr:first-child {
	height:60px;
	}
#table-order-history th {
	height:40px;
	background:#ccc;
	text-align:center;
    }
#table-order-history th:first-child {
	text-align: left;
	padding-left:20px;
	-moz-border-radius-topleft:3px;
	-webkit-border-top-left-radius:3px;
	border-top-left-radius:3px;
	border-left:1px solid transparent;
	}
#table-order-history th:last-child {
	-moz-border-radius-topright:3px;
	-webkit-border-top-right-radius:3px;
	border-top-right-radius:3px;
	}
#table-order-history td {
	text-align:center;
	line-height: 30px;
	}
#table-order-history img {
	width:50px;
	height:50px;
	margin-right:15px;
	}
#table-order-history .odd-row td{
	background:#f8f8f8;
	}
</style>

<script>
	$(function() {
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
                        <div class="title">ประวัติการสั่งซื้อ</div>
                        <table id="table-order-history" >
                            <thead>
                        	<tr>
                            	<th width="15%">หมายเลขสั่งซื้อ</th>
                                <th width="20%">วันที่สั่ง</th>
                                <th width="20%">สถานะการสั่งสินค้า</th>
                                <th width="20%">ยอดรวม</th>
                                <th width="20%">อัพเดทเมื่อวันที่</th>
                                <th width="5%">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $key => $order)
                                <tr >
                                    <td width="15%">{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td width="15%">{{ $order->created_at }}</td>
                                    <td width="20%">
                                        @if($order->status->id == 1)
                                            <i class="fa fa-clock-o"></i>
                                        @elseif($order->status->id == 2)
                                            <i class="fa fa-check-circle"></i>
                                        @endif
                                        &nbsp;{{ $order->status->name }}</td>
                                    <td>{{ number_format($order->subTotal(), 2)  }}</td>
                                    <td>{{ $order->updated_at->format('d/m/Y H:i:s') }}</td>
                                    <td><a href="{{ action('UserController@getShowOrder', [$user->id, $order->id]) }}" class="btn btn-default"><i class="fa fa-search"></i>&nbsp;ดูรายละเอียด</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">{!! str_replace('/?', '?', $orders->render()) !!}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop