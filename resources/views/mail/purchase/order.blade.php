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
			
		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding:25px;font-size:14px;">
			<p><b>สวัสดี</b>คุณศักรินทร์</p>
			<p>เราได้รับการสั่งซื้อของคุณเป็นที่เรียบร้อยแล้ว</p>
			<p>คุณสามารถชำระเงินได้ตามช่องทางต่าง ๆ ของเรา ดังนี้</p>
			<ol style="line-height:24px;">
				<li>
					<strong>ธนาคารกรุงเทพ</strong>
                	<br>เลขที่: 616-7-132742
                	<br>ชื่อบัญชี: ร้าน มูบาซ่า
				</li>
				<li>
					<strong>ธนาคารกรุงไทย</strong>
                	<br>เลขที่: 443-0-59537-2
                	<br>ชื่อบัญชี: มูบาซ่า โดย นายชาวพุทธ นวกาลัญญู
				</li>
				<li>
					<strong>ธนาคารกสิกรไทย</strong>
                	<br>เลขที่: 512-2-51660-3
                	<br>ชื่อบัญชี: ร้าน มูบาซ่า
	            </li>
				<li>
					<strong>ธนาคารทหารไทย</strong>
                	<br>เลขที่: 465-2-23726-6
                	<br>ชื่อบัญชี: ร้าน มูบาซ่า โดย นายชาวพุทธ นวกาลัญญู
				</li>
			</ol>
			<p>โปรดตรวจสอบการสั่งซื้อของคุณให้เรียบร้อย ก่อนชำระเงิน</p>
			<p>
				<a style="padding: 15px 35px;background:#0096ff;display:inline-block;color: #fff;text-decoration: none;border-radius: 4px;" href="{{url('/')}}">แจ้งการชำระเงิน</a>
			</p>
			<p>การสั่งซื้อของคุณ มีรายละเอียดดังนี้</p>
			<h3>การสั่งซื้อหมายเลข <strong style="color:#f12b24">gg15233641126</strong> ที่สั่งเข้ามาวันที่ <strong style="color:#f12b24">24 ธันวาคม 2558</strong></h3>
			<table width="100%" cellspacing="0" style="border:1px solid #ddd; padding:10px; border-radius:4px;font-size: 14px;">
				<thead style="line-height:30px; ">
					<tr>
						<th colspan="6" style="background:#ddd;">
							รายละเอียดการสั่งซื้อ
						</th>
					</tr>
					<tr>
						<th style="border-bottom: 1px solid #ddd;"> 
							ลำดับ
						</th>
						<th style="border-bottom: 1px solid #ddd;" width="150px">
							
						</th>
						<th style="border-bottom: 1px solid #ddd;">
							สินค้า
						</th>
						<th style="border-bottom: 1px solid #ddd;">
							ไซต์
						</th>
						<th style="border-bottom: 1px solid #ddd;">
							จำนวน
						</th>
						<th style="border-bottom: 1px solid #ddd;">
							รวม
						</th>
					</tr>
				</thead>
				<tbody style="vertical-align:top;">
					@for ($i=0; $i<5; $i++)
					<tr>
						<td width="5%" style="padding:10px 5px; text-align:center;">
							{{$i+1}}
						</td>
						<td width="150px">
							<img style="width:100%;" src="{{asset('images/mockup/img1.jpg')}}" alt="">
						</td>
						<td width="50%" style="padding:10px 5px;">
							<p>เสื้อยืดมาตรฐาน คอกลม สีเทา</p> 
							<p>test name tshirt</p>
						</td>
						<td width="10%" style="padding:10px 5px; text-align:center;">
							M
						</td>
						<td width="10%" style="padding:10px 5px; text-align:center;">
							10
						</td>
						<td width="10%" style="padding:10px 5px; text-align:center;">
							1500
						</td>
					</tr>
					@endfor
				</tbody>

				<tfoot>
					<tr>
						<td colspan="4" style="text-align:right;padding:10px 15px;border-top: 1px solid #ddd;">
							รวมราคา(บาท)
						</td>
						<td colspan="2" style="text-align:right;padding:10px 15px;border-top: 1px solid #ddd;">
							3500
						</td>
					</tr>
					<tr>
						<td colspan="4" style="text-align:right;padding:10px 15px;">
							ค่าขนส่ง(บาท)
						</td>
						<td colspan="2" style="text-align:right;padding:10px 15px;">
							150
						</td>
					</tr>
					<tr>
						<td colspan="4" style="text-align:right;padding:10px 15px;">
							ส่วนลด
						</td>
						<td colspan="2" style="text-align:right;padding:10px 15px;">
							150
						</td>
					</tr>
					<tr>
						<td colspan="4" style="text-align:right;padding:10px 15px;">
							<h4>รวมทั้งสิ้น(บาท)</h4>
						</td>
						<td colspan="2" style="text-align:right;padding:10px 15px;">
							<h4>3500</h4>
						</td>
					</tr>
				</tfoot>
			</table>
			<table width="100%" cellspacing="0" style="border:1px solid #ddd; padding:10px; border-radius:4px;font-size: 14px;margin-top:25px;">
				<thead style="line-height:30px; ">
					<tr>
						<th colspan="6" style="background:#ddd;">
							รายละเอียดการจัดส่งสินค้า
						</th>
					</tr>
				</thead>
				<tbody style="vertical-align:top;">
					<tr>
						<td width="25%" style="padding:10px 5px; text-align:right;">
							ชื่อ-สกุล ผู้รับ :
						</td>
						<td width="75%" style="padding:10px 5px; text-align:left;">
							1500
						</td>
					</tr>
					<tr>
						<td width="25%" style="padding:10px 5px; text-align:right;">
							ที่อยู่ :
						</td>
						<td width="75%" style="padding:10px 5px; text-align:left;">
							65432132ฟกหฟหเกหฟเำเพกดหิห้ะำ้เพดกเ
						</td>
					</tr>
					<tr>
						<td width="25%" style="padding:10px 5px; text-align:right;">
							เบอร์โทร :
						</td>
						<td width="75%" style="padding:10px 5px; text-align:left;">
							0844545412
						</td>
					</tr>
					<tr>
						<td width="25%" style="padding:10px 5px; text-align:right;">
							อีเมลล์ :
						</td>
						<td width="75%" style="padding:10px 5px; text-align:left;">
							ฟหกดฟห่สกา่หสอา
						</td>
					</tr>
					<tr>
						<td width="25%" style="padding:10px 5px; text-align:right;">
							วิธีการจัดส่ง :
						</td>
						<td width="75%" style="padding:10px 5px; text-align:left;">
							ems
						</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
</table>
@stop