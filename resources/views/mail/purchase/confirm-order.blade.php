@extends('mail.layouts.email-page')
@section('content')
<table style="width: 100%;padding:25px;">
	<tr>
		<td width="25%" style="color:#5eba1c;height:50px;padding:0 25px;">				
			<a href="{{url('/')}}" style="color:#000;text-decoration:none;">
				<img src="{{asset('images/logo-gg7.png')}}" alt="GG7logo" style="height:40px;">
				<p>www.ggseven.com</p>
			</a>
		</td>
		<td width="75%">
			<h1 style="margin: 0px;color:#0096ff" >ขอบคุณสำหรับการสั่งซื้อสินค้า</h1>
			<h4>คำสั่งซื้อหมายเลข gg15233641126 ของคุณ ชำระเงินเรียบร้อยแล้ว</h4>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding:25px;font-size:14px;">
			<p><b>สวัสดี</b>คุณศักรินทร์</p>
			<p>คำสั่งซื้อหมายเลข <strong style="color:#CF000F;">gg15233641126</strong> ยืนยัยการชำระเงินวันที่ <strong style="color:#CF000F;">25 ธันวาคม 2558</strong> ยอดเงิน <strong style="color:#CF000F;">1520.02</strong> บาท ของคุณ ได้รับการยืนยันการชำระเงินเรียบร้อยแล้ว</p>
			<p>คุณสามารถติดตามสถานะคำสั่งซื้อนี้ได้จากช่องทางต่าง ๆ ดังนี้</p>
			<ol>
				<li>
					เข้าไปที่ <a href="#">Tracking Order</a> แล้วค้นหาหมายเลขคำสั่งซื้อของคุณ
				</li>
				<li>
					<p>สแกน QR Code นี้</p>
					<img style="height:150px;" src="{{asset('images/tshirt-loading-s.gif')}}" alt="QR Code">
				</li>
			</ol>
			<p>ขอบคุณสำหรับความไว้วางในในผลิตภัณฑ์ของเรา</p>
			<p>ทีมงาน GG7</p>
		</td>
	</tr>
</table>
@stop