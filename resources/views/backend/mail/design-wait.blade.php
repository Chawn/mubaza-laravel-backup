@extends('backend.layouts.email')
@section('content')
	<table width="100%">
		<thead style="border-bottom:1px solid #ddd;">
			<tr>
				<td rowspan="2" width="50%" style="border-right:1px solid #ddd;text-align:center;color:#e67e22;">
					<h3>รอการชำระเงิน</h3>
				</td>
				<td width="50%" style="padding:10px;">
					<b>รหัสการสั่งซื้อ &nbsp;&nbsp;<span style="color:#e67e22;">{{ $order_id }}</span></b>
				</td>
			</tr>
			<tr>				
				<td width="50%" style="padding:10px;">
					<b>ยอดที่ต้องชำระ &nbsp;&nbsp;<span style="color:#e67e22;">{{ $sub_total }}</span></b>
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
				<td width="50%" style="padding:15px;">
					<img width="50%" src="{{ $campaign_image_front_preview }}">
				</td>
				<td width="50%" style="vertical-align:top;padding:15px;">
					<p><b>เสื้อยืดผ้าฝ้ายสีขาว</b></p>
					@foreach($all_items as $item)
                        <p>ขนาด {{ $item['size'] }} จำนวน {{ $item['qty'] }} ตัว</p>
                    @endforeach
				</td>
			</tr>
			<tr>
				<td colspan="2" style="border-top:1px solid #ddd;padding:15px;">
					<h4>รายละเอียดผู้รับสินค้า</h4>
				
					<p><b>ชื่อ&nbsp;-&nbsp;สกุล&nbsp;&nbsp;</b>{{ $shipping_address['full_name'] }}</p>
					<p>
                        <b>ที่อยู่&nbsp;&nbsp;</b>{{ $shipping_address['address'] }}&nbsp;{{ $shipping_address['district'] }}&nbsp;{{ $shipping_address['province'] }}&nbsp;{{ $shipping_address['zipcode'] }}</p>
					<p><b>เบอร์โทร&nbsp;&nbsp;</b>{{ $shipping_address['phone'] }}</p>
					<p><b>อีเมล์&nbsp;&nbsp;</b>{{ $user_email }}</p>
				</td>
			</tr>
			<tr>
				<td colspan="2" height="80px" style="border-top:1px solid #ddd;text-align:center;padding:15px;">
					<a href="#"
						style="background:#5cb85c;color:#fff;padding:10px 20px;text-decoration:none;border-radius:5px;">แจ้งชำระเงิน</a>					
				</td>
			</tr>
		</tbody>
	</table>
@stop