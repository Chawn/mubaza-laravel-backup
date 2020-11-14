@extends('backend.layouts.email')
@section('content')
<table width="100%" cellspacing="10">
	<thead>
		<tr>
			<td colspan="2" style="text-align:left;">
				<h2>ยืนยันการชำระการสั่งซื้อรหัส&nbsp;:&nbsp;128128</h2>
				<b>สวัสดี&nbsp;เอ้ เพลิน เพลิน</b>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p>
					คำสั่งซื้อของคุณได้รับการตรวจสอบว่าได้ชำระเงินเรียบร้อยแล้ว ขั้นตอนต่อไป ทางเราจะดำเนินการผลิตสินค้าและจัดส่งสินค้า 
				</p>
				<p>
					ทางเราจะทำการอัพเดทสถานะการสั่งซื้อของคุณเป็นระยะทางอีเมลล์นี้ หรือคุณสามารถติดตามการอัพเดทสถานะการสั่งซื้อของคุณได้ที่หน้า ประวัติการสั่งซื้อ ของคุณ
				</p>
				<p>
					ทางเราขอขอบคุณสำหรับการสั่งซื้อสินค้าที่ GGSEVEN ของเราเป็นอย่างยิ่ง
				</p>
				<p>
					ทั้งนี้โปรดใช้รหัสการสั่งซื้อและวันที่ชำระเงินนี้ เพื่อเป็นการอ้างอิง  ทางเราขอแจ้งรายละเอียดการสั่งซื้อ ดังนี้ 
				</p>
			</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<table width="100%" cellspacing="0" style="border:3px solid #aaa;margin-top:15px;padding:10px;">
					<thead>
						<tr>
							<td rowspan="2" width="50%" style="text-align:center;border-right:1px solid #ddd;padding-top:15px;">
								<p>สถานะการสั่งซื้อ</p>
								<h3 style="color:#82bc00;">ชำระเงินแล้ว</h3>
							</td>
							<td width="50%" style="padding:10px;">
								<b>รหัสการสั่งซื้อ&nbsp;:&nbsp;<span>#123123</span></b>
							</td>
						</tr>
						<tr>				
							<td width="50%" style="padding:10px;">
								<b>วันที่ชำระเงิน&nbsp;:&nbsp;<span>12/12/24</span></b>
							</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="2" style="padding:0 0 0 15px;border-top:1px solid #ddd;border-bottom:1px solid #ddd;">
								<h4 style="line-height:50px;vertical-align:middle;margin:0;text-align:center;">รายละเอียดการสั่งซื้อสินค้า</h4>
							</td>
						</tr>
						<tr>
							<td width="50%" style="border:1px solid #ddd;">
								<table>
									<tr>
										<td width="50%">
											<img style="width:100%;" src="{{ asset('images/mockup/img12.jpg')}}" alt="">
										</td>
										<td width="50%">
											<a style="color:244c7d;" href="#">เสื้อยืดศักรินทร์</a>
											<p>ขนาด&nbsp;M</p>
											<p>จำนวน&nbsp;2&nbsp;ตัว</p>
											<p>ราคารวม&nbsp;256&nbsp;</p>
										</td>
									</tr>
								</table>
							</td>
							<td width="50%" style="border:1px solid #ddd;">
								<table>
									<tr>
										<td width="50%">
											<img style="width:100%;" src="{{ asset('images/mockup/img3.jpg')}}" alt="">
										</td>
										<td width="50%">
											<a style="color:244c7d;" href="#">เสื้อยืดศักรินทร์</a>
											<p>ขนาด&nbsp;M</p>
											<p>จำนวน&nbsp;2&nbsp;ตัว</p>
											<p>ราคารวม&nbsp;256&nbsp;</p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td width="50%" style="border:1px solid #ddd;">
								<table>
									<tr>
										<td width="50%">
											<img style="width:100%;" src="{{ asset('images/mockup/img2.jpg')}}" alt="">
										</td>
										<td width="50%">
											<a style="color:244c7d;" href="#">เสื้อยืดศักรินทร์</a>
											<p>ขนาด&nbsp;M</p>
											<p>จำนวน&nbsp;2&nbsp;ตัว</p>
											<p>ราคารวม&nbsp;256&nbsp;</p>
										</td>
									</tr>
								</table>
							</td>
							<td width="50%" style="border:1px solid #ddd;">
								<table>
									<tr>
										<td width="50%">
											<img style="width:100%;" src="{{ asset('images/mockup/img1.jpg')}}" alt="">
										</td>
										<td width="50%">
											<a style="color:244c7d;" href="#">เสื้อยืดศักรินทร์</a>
											<p>ขนาด&nbsp;M</p>
											<p>จำนวน&nbsp;2&nbsp;ตัว</p>
											<p>ราคารวม&nbsp;256&nbsp;</p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td></td>
							<td style="padding:20px 0 0 0;">
								<table width="100%">
									<tr>
										<td width="50%" style="text-align:right;">
											วิธีการชำระเงิน&nbsp;:&nbsp;
										</td>
										<td width="50%" style="text-align:right;">
											โอนเงินผ่านธนาคาร
										</td>
									</tr>
									<tr>
										<td width="50%" style="text-align:right;">
											ค่าขนส่ง&nbsp;:&nbsp;
										</td>
										<td width="50%" style="text-align:right;">
											35.00
										</td>
									</tr>
									<tr>
										<td width="50%" style="text-align:right;">
											<h4>ยอดรวมสุทธิ&nbsp;:&nbsp;</h4>
										</td>
										<td width="50%" style="text-align:right;">
											<h4>฿1235.00</h4>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:right;border-top:1px solid #ddd;padding-top:8px;">
								<p>(VAT inclusive)</p>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:3px solid #aaa">
				<table cellspacing="0" width="100%">
					<thead>
						<tr>
							<th style="background:#aaa;padding:10px;">
								ข้อมูลการจัดส่ง
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="padding:10px;">
								<p><label>ชื่อผู้รับ&nbsp;:&nbsp;</label>ปรียานุช นามมา</p>
								<p><label>ที่อยู่&nbsp;:&nbsp;</label>231/136 หมู่บ้านพี.เค.2 ถ.อุดรดุษฎี ซอย 5 ต.หมากแข้ง อ.เมือง จ.อุดรธานี 41000</p>
								<p><label>เบอร์โทร&nbsp;:&nbsp;</label>0844094069</p>
								<p><label>อีเมลล์&nbsp;:&nbsp;</label>aeglamorous@gmail.com</p>
								<p><label>วิธีการจัดส่ง&nbsp;:&nbsp;</label>Kerry Express</p>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>				
	</tbody>
</table>
@stop