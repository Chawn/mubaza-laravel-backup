<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ใบสั่งผลิต</title>
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
    	var detailHeight = $('.production-detail').height();

    	if (detailHeight >= 315) {
    		$('.production-detail .table-data tbody .blank').hide();
    	}else{
    		$('.production-detail .table-data tbody .blank').height( 315 - detailHeight );
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
							<h2>ใบสั่งผลิต</h2>
							<h4>Production Order</h4>
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
						<p><label>เลขที่ใบสั่งผลิต&nbsp;:&nbsp;</label></p>
						<p><label>เลขที่ใบสั่งขาย&nbsp;:&nbsp;</label></p>
						<p><label>วันที่&nbsp;:&nbsp;</label></p>
						<p><label>วันที่กำหนดส่ง&nbsp;:&nbsp;</label></p>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2" class="production-detail">
						<table class="table-data">
							<thead>
								<tr>
									<th colspan="5" class="title">
										รายละเอียดสินค้า
									</th>
								</tr>
								<tr>
									<th width="12%">
										รหัสสินค้า
									</th>
									<th width="52%">
										รายการสินค้า
									</th>									
									<th width="12%">
										สี
									</th>
									<th width="12%">
										ขนาด
									</th>
									<th width="12%">
										จำนวน (ชิ้น)
									</th>									
								</tr>
							</thead>
							<tbody>
								@for($i=0;$i<10;$i++)
								<tr>
									<td>0000011{{$i}}</td>
									<td>เสื้อยืด มาตรฐาน</td>
									<td>สีกรมท่า</td>
									<td class="text-center">S</td>
									<td class="text-center">128</td>
								</tr>
								@endfor
								<tr class="blank">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>	
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="production-print">
						<table class="table-data">
							<thead>
								<tr>
									<th class="title" colspan="2">
										รายละเอียดการสกรีน
									</th>
								</tr>
								<tr>
									<th width="50%">
										ด้านหน้า
									</th>
									<th width="50%">
										ด้านหลัง
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										ขนาด 9*8 cm สกรีนอกซ้าย สี ขาว ดำ แดง
									</td>
									<td>
										ขนาด กลางหลัง
									</td>
								</tr>
								<tr>
									<td class="text-center">
										<img class="mockup" src="{{asset('images/mockup/img9.jpg')}}" alt="">
									</td>
									<td class="text-center">
										<img class="mockup" src="{{asset('images/mockup/img9.jpg')}}" alt="">
									</td>
								</tr>
							</tbody>
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