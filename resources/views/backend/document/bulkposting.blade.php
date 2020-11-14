<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ใบฝากของรวม</title>
    <link rel="stylesheet" href="{{ asset('css/cssreset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/document.css') }}">
</head>
<body>
<div class="page">
	<table class="blukposting" cellspacing="5">
		<thead>
			<tr>
				<th colspan="4" class="text-center">
					
					<h2>ใบรับฝากรวม</h2>
					<h3>RECEIPT FOR BULK POSTING</h3>
					<p>วันที่&nbsp;:&nbsp;12-12-15</p>	
				</th>
			</tr>
			<tr>
				<th width="25%" rowspan="2" class="text-right">
					<p>ได้รับฝาก&nbsp;(Received)</p>
				</th>
				<th width="25%" class="">				
					<label class="checkbox table-cell pull-left"><i class="fa fa-2x fa-square-o"></i></label>
					<p>ไปรษณียภัณฑ์&nbsp;(Letter-Post items)</p>			
				</th>
				<th width="25%" class="">				
					<label class="checkbox table-cell pull-left"><i class="fa fa-2x fa-square-o"></i></label>
					<p>ลงทะเบียน&nbsp;(Registered)</p>			
				</th>
				<th width="25%" class="">				
					<label class="checkbox table-cell pull-left"><i class="fa fa-2x fa-square-o"></i></label>
					<p>รับรอง&nbsp;(Certified)</p>			
				</th>
			</tr>
			<tr>
				<th width="25%" class="text-left">				
					<label class="checkbox table-cell pull-left"><i class="fa fa-2x fa-square-o"></i></label>
					<p>พัสดุไปรษณีย์&nbsp;(Parcels)</p>			
				</th>
				<th width="25%" class="text-left">				
					<label class="checkbox table-cell pull-left"><i class="fa fa-2x fa-square-o"></i></label>
					<p>รับประกัน&nbsp;(Insured)</p>			
				</th>
				<th width="25%" class="text-left">				
					<label class="checkbox table-cell pull-left"><i class="fa fa-2x fa-square-o"></i></label>
					<p>ไปรษณีย์ด่วนพิเศษ&nbsp;(EMS)</p>			
				</th>
			</tr>
			<tr>
				<th></th>
				<th colspan="3">
					<h3 class="text-bold">จาก&nbsp;:&nbsp;ร้านมูบาซ่า&nbsp;197/63&nbsp;ถ.เบญจางค์&nbsp;ต.หมากแข้ง&nbsp;อ.เมือง&nbsp;จ.อุดรธานี&nbsp;41000</h3>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="4">
					<table class="table-border">
						<thead>
							<tr>
								<th width="10%" rowspan="2">
									<p>ลำดับ</p>
									<p>No.</p>
								</th>
								<th width="30%" rowspan="2">
									<p>นามผู้รับ</p>
									<p>Name of addressee</p>
								</th>
								<th width="15%" rowspan="2">
									<p>ปลายทาง</p>
									<p>Destination</p>
								</th>
								<th width="15%" rowspan="2">
									<p>เลขที่</p>
									<p>Number</p>
								</th>
								<th width="5%" rowspan="2">
									<p>น้ำหนัก</p>
									<p>(กรัม)</p>
									<p>Weight</p>
									<p>(Grammes)</p>
								</th>
								<th width="15%" colspan="2">
									<p>ค่าบริการ</p>
									<p>Postal Charge</p>
								</th>
								<th width="10%" rowspan="2">
									<p>หมายเหตุ</p>
									<p>Remarks</p>
								</th>
							</tr>
							<tr>
								<th width="10%">
									<p>บาท</p>
									<p>Baht</p>
								</th>
								<th width="5%">
									<p>สต.</p>
									<p>Stg.</p>
								</th>
							</tr>
						</thead>
						<tbody>
							@for($i=0; $i<25;$i++)
							<tr>
								<td>{{$i}}</td>
								<td>มูบาซ่า</td>
								<td>อุดร</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							@endfor
						</tbody>
						<tfoot>
							<tr>
								<td></td>
								<td colspan="4" class="text-right td-total">
									<h3>รวมทั้งสิ้น 25 ห่อ</h3>
								</td>
								<td class="td-total">
									
								</td>
								<td class="td-total">
																
								</td>
								<td></td>
							</tr>
							<tr>
								<td colspan="2"></td>
								<td colspan="5" class="counter">
									<h3>
										พนักงานรับฝาก&nbsp;......................................................................
									</h3>
								</td>
							</tr>
						</tfoot>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="page-break"></div>
	
</body>