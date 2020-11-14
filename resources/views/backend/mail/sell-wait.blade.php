@extends('backend.layouts.email')
@section('content')
	<table width="100%" style="border:1px solid #ddd">
		<thead style="border-bottom:1px solid #ddd;">
			<tr>
				<td colspan="2" 
					style="text-align:center;background:#f1f1f1;border-bottom:1px solid #ddd;">
					<h3>แคมเปญ&nbsp;&nbsp;{{ $campaign_title }}</h3>
				</td>
			</tr>
			<tr>
				<td rowspan="3" width="50%" style="border-right:1px solid #ddd;text-align:center;color:#e67e22;">
					<h3>รอการชำระเงิน</h3>
				</td>
				<td width="50%" style="padding:10px 0 5px 5px;">
					<b>รหัสการสั่งซื้อ &nbsp;&nbsp;<span style="color:#e67e22;">{{ $order_id }}</span></b>
				</td>
			</tr>
			<tr>				
				<td width="50%" style="padding:5px;">
					<b>ยอดที่ต้องชำระ &nbsp;&nbsp;<span style="color:#e67e22;">{{ $sub_total }}</span></b>
				</td>
			</tr>
			<tr>				
				<td width="50%" style="padding:5px 0 10px 5px;">
					<b>ชำระได้ถึง&nbsp;&nbsp;<span style="color:#e67e22;">{{ $close_date }} (วันก่อนวันปิด 1 วัน)</span></b>
				</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="2" style="padding:0 0 0 15px;">
					<h4>รายละเอียดการสั่งซื้อสินค้า</h4>
				</td>
			</tr>

			<tr>
				<td colspan="2" height="80px" style="border-top:1px solid #ddd;text-align:center;padding:15px;">
					<a href="{{ action('OrderController@getPayment') }}"
						style="background:#5cb85c;color:#fff;padding:10px 20px;text-decoration:none;border-radius:5px;">แจ้งชำระเงิน</a>					
				</td>
			</tr>
		</tbody>
	</table>
@stop