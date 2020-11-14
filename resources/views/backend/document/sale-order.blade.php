<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ใบสั่งขาย</title>
    <script src="{{ asset('jquery/dist/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/cssreset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/document.css') }}">
    <style>
		.page{
			padding: 10px;
		}
    </style>
    <script>
    $(document).ready(function() {
    	var dataHeight = $('.saleorder').height();

    	if ( dataHeight >= 480 ) {
    		$('.blank td').hide();
    	}else {
    		$('.blank td').height( 480 - dataHeight);
    	}

    });
    </script>
</head>
<body>
	<div class="page">
		<table class="blukposting" cellspacing="5">
			<thead>
				<tr>
					<th colspan="2">
						@include('backend.document.include.header')
					</th>
				</tr>
				<tr>
					<th class="text-center" colspan="2">
						<div>
							<h2>ใบสั่งขาย</h2>
							<h4>Sale Order</h4>
						</div>
					</th>
				</tr>
				<tr>
					<th width="50%" class="border">
						<p><label>ชื่อลูกค้า&nbsp;:&nbsp;</label></p>
						<p><label>ที่อยู่&nbsp;:&nbsp;</label></p>
						<p><label>เบอร์โทร&nbsp;:&nbsp;</label></p>
					</th>
					<th width="50%" class="border">
						<p><label>เลขที่ใบสั่งขาย&nbsp;:&nbsp;</label></p>
						<p><label>วันที่&nbsp;:&nbsp;</label></p>
						<p><label>วันที่กำหนดส่ง&nbsp;:&nbsp;</label></p>
						<p><label>จำนวนวันเครดิต&nbsp;:&nbsp;</label></p>
						<p><label>เงื่อนไขการวางบิล&nbsp;:&nbsp;</label></p>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2">
						<table class="table-data">
							<thead>
								<tr>
									<th colspan="6" class="title">
										รายละเอียดสินค้า
									</th>
								</tr>
								<tr>
									<th width="10%">
										รหัสสินค้า
									</th>
									<th width="50%">
										รายการสินค้า
									</th>									
									<th width="10%">
										จำนวน (ชิ้น)
									</th>
									<th width="10%">
										ราคาต่อหน่วย
									</th>
									<th width="10%">
										ส่วนลด
									</th>
									<th width="10%">
										จำนวนเงิน
									</th>									
								</tr>
							</thead>
							<tbody class="saleorder">
								@for($i=0;$i<10;$i++)
									<tr>
										<td>0000011{{$i}}</td>
										<td>เสื้อยืด มาตรฐาน สีกรมท่า ขนาด S</td>
										<td class="text-center">128</td>
										<td class="text-center">99</td>
										<td class="text-center">-</td>
										<td class="text-center">12800</td>
									</tr>
								@endfor
									<tr class="blank">
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2" rowspan="4">
										หมายเหตุ
									</td>
									<td colspan="2">รวมเงิน</td>
									<td colspan="2" class="text-right">12800</td>
								</tr>
								<tr>
									<td colspan="2">ส่วนลดการค้า</td>
									<td colspan="2" class="text-right">-</td>
								</tr>
								<tr>
									<td colspan="2">เงินหลังหักส่วนลด</td>
									<td colspan="2" class="text-right">1111111</td>
								</tr>
								<tr>
									<td colspan="2">ภาษีมูลค่าเพิ่ม</td>
									<td colspan="2" class="text-right">22</td>
								</tr>
								<tr>
									<td colspan="2"><label>(หนึ่งพันสองร้อยแปดสิบบาทถ้วน)</label></td>
									<td colspan="2"><label>จำนวนเงินทั้งสิ้น</label></td>
									<td colspan="2" class="text-right"><label>1280</label></td>
								</tr>
							</tfoot>	
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="production-footer">
						<table class="table-footer">

							<tbody cellspacing="10">
								<tr>
									<td>
										<hr>
										<p>พนักงานขาย</p>
										<p>12/10/2558</p>
									</td>
									<td>
										<hr>
										<p>พนักงานฝ่ายผลิต</p>
										<p>12/10/2558</p>
									</td>
									<td>
										<hr>
										<p>ลูกค้า</p>
										<p>12/10/2558</p>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>	
		</table>
	</div>

	<div class="page-break"></div>
</body>