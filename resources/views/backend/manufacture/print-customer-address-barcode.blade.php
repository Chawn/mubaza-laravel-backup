<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>พิมพ์ใบปะหน้าซอง</title>
    <link rel="stylesheet" href="{{ asset('css/print-customer-address.css') }}">
    <script src="{{ asset('jquery/dist/jquery.min.js') }}"> </script>
    <script src="{{ asset('js/jquery-barcode.js') }}"></script>
    <style>
        body {
            font-family: 'Tahoma';
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        

        .page td {
            width: 487px;
            /*
            height: 675px;
            */
            vertical-align: top;
            padding:5px;
        }
        .bottom{
        	vertical-align:  bottom !important;
        	height: 160px;
        }
        @media all {
            .page-break {
                display: none;
            }
        }

        @media print {
            .page-break {
                display: block;
                height: 1px;
                page-break-after: always;
            }  
        }		
    </style>

    <script>
    $(document).ready(function() {
    	$('.order-id').append('<div class="bcTarget">');
    	$('.bcTarget').each(function() {
    		
    		$(this).barcode('PO12300123','code39',{barWidth:2, barHeight:80})
		    
		});
    });
    </script>
</head>
<body>

<div class="page-a5">
	<table class="label">
		<tbody>
			<tr>
				<td width="50%">
					<div class="box-order">
						<div class="box-order-header">
							<div class="box-logo">
								<img class="logo" src="{{ asset('images/logo-short.jpg') }}">
							</div>
							<div class="box-header">
								<h2>Shipment Details</h2>
								<p>track this shipment : http://www.{{ config('profile.sitename') }}</p>
							</div>
						</div>
						<div class="box-order-body">
							<div class="detail">
								<table class="table-detail" cellspacing="0">
									<thead>
										<tr>
											<th class="box-head" colspan="3">
												Order ID <span>PO000000128</span>
											</th>
										</tr>
										<tr>
											<th width="60%">
												Product
											</th>
											<th width="20%">
												Size
											</th>
											<th width="20%">
												Quantity
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<p><span>ชื่อสินค้า&nbsp;:&nbsp;</span>'พวกเรา นนส.ทบ.' แบบที่ ๒</p>
												
											</td>
											<td>										
											</td>
											<td>
												
											</td>
										</tr>
										@for($i=0; $i<10; $i++)
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										@endfor
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</td>
				<td width="50%">
					<div class="box-shipment">
						<table cellspacing="0">
							<tr>
								<td class="shipment-way text-center">
									<h3>Shipment Way</h3>
									<h3>Curry Express</h3>
								</td>
								<td class="shipment-id">
									<p>shipment ID here</p>
								</td>
							</tr>
						</table>						
					</div>
					<div class="from">
						<h3>From&nbsp;:&nbsp;Mubaza</h3>
						<p>231/136 soi 5 Udondusadee Road, Mak Khaeng, Mueang Udon Thani, Udon Thani, 41000</p>
					</div>
					<div class="box-customer">
						<div class="box-customer-header">
							<h1><span>To&nbsp;:&nbsp;</span>ศักรินทร์  ดาวร้าย</h1>
						</div>
						<div class="box-customer-address">
							<p>แฟรตสรรพวุธ 1</p>
                    		<p>818/99 ซอยสรรพวุธนิเวศน์ ถนนพระราม 5 แขวงถนนนครไชยศรี</p>
                    		<p>อ.เขตดุสิต&nbsp;จ.กรุงเทพมหานคร</p>
                    		<p>โทร&nbsp;0982873194</p>
						</div>
						<div class="zipcode">
							<h1>13000</h1>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td class="bottom">					
					<div class="box-caution">
						<h3>DO NOT ACCEPT IF SEAL IS BROKEN</h3>
						<p>all product at {{ config('profile.sitename') }} come with manufacturer's warranty where applicable</p>
						<p>
							Mubaza allows easy replcement for wrong size, color, quantity, style, manufaturing defects, damaged or significantlu different from product listing
						</p>
						<p><b>Customer Support&nbsp;</b>call&nbsp;:&nbsp;{{ config('profile.phone-primary') }},  <br>
						email&nbsp;:&nbsp;{{ config('profile.email') }}</p>
					</div>
				</td>
				<td class="bottom">
					<div class="box-barcode">
						<div class="order-id" >
							<h4>Order ID</h4>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="page-a5">
	<table class="label">
		<tbody>
			<tr>
				<td width="50%">
					<div class="box-order">
						<div class="box-order-header">
							<div class="box-logo">
								<img class="logo" src="{{ asset('images/logo-short.jpg') }}">
							</div>
							<div class="box-header">
								<h2>Shipment Details</h2>
								<p>track this shipment : http://www.{{ config('profile.sitename') }}</p>
							</div>
						</div>
						<div class="box-order-body">
							<div class="detail">
								<table class="table-detail" cellspacing="0">
									<thead>
										<tr>
											<th class="box-head" colspan="3">
												Order ID <span>PO000000128</span>
											</th>
										</tr>
										<tr>
											<th width="60%">
												Product
											</th>
											<th width="20%">
												Size
											</th>
											<th width="20%">
												quantity
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<p><span>ชื่อสินค้า&nbsp;:&nbsp;</span>'พวกเรา นนส.ทบ.' แบบที่ ๒</p>
												
											</td>
											<td>										
											</td>
											<td>
												
											</td>
										</tr>

										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</td>
				<td width="50%">
					<div class="box-shipment">
						<table cellspacing="0">
							<tr>
								<td class="shipment-way text-center">
									<h3>Shipment Way</h3>
									<h3>Curry Express</h3>
								</td>
								<td class="shipment-id">
									<p>shipment ID here</p>
								</td>
							</tr>
						</table>						
					</div>
					<div class="from">
						<h3>From&nbsp;:&nbsp;Mubaza</h3>
						<p>231/136 soi 5 Udondusadee Road, Mak Khaeng, Mueang Udon Thani, Udon Thani, 41000</p>
					</div>
					<div class="box-customer">
						<div class="box-customer-header">
							<h1><span>To&nbsp;:&nbsp;</span>ศักรินทร์  ดาวร้าย</h1>
						</div>
						<div class="box-customer-address">
							<p>แฟรตสรรพวุธ 1</p>
                    		<p>818/99 ซอยสรรพวุธนิเวศน์ ถนนพระราม 5 แขวงถนนนครไชยศรี</p>
                    		<p>อ.เขตดุสิต&nbsp;จ.กรุงเทพมหานคร</p>
                    		<p>โทร&nbsp;0982873194</p>
						</div>
						<div class="zipcode">
							<h1>13000</h1>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td class="bottom">					
					<div class="box-caution">
						<h3>DO NOT ACCEPT IF SEAL IS BROKEN</h3>
						<p>all product at {{ config('profile.sitename') }} come with manufacturer's warranty where applicable</p>
						<p>
							Mubaza allows easy replcement for wrong size, color, quantity, style, manufaturing defects, damaged or significantlu different from product listing
						</p>
						<p><b>Customer Support&nbsp;</b>call&nbsp;:&nbsp;{{ config('profile.phone-primary') }},  <br>
						email&nbsp;:&nbsp;{{ config('profile.email') }}</p>
					</div>
				</td>
				<td class="bottom">
					<div class="box-barcode">
						<div class="order-id" >
							<h4>Order ID</h4>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="page-break"></div>
<!--
	<table class="page">
		<tbody>
			<tr>
				<td>
					<div class="box-order">
						<div class="box-order-header">
							<div class="box-logo">
								<img class="logo" src="{{ asset('images/logo-short.jpg') }}">
							</div>
							<div class="box-header">
								<h2>Shipment Details</h2>
								<p>track this shipment : http://www.{{ config('profile.sitename') }}</p>
							</div>
						</div>
						<div class="box-order-body">
							<div class="detail">
								<table class="table-detail" cellspacing="0">
									<thead>
										<tr>
											<th class="box-head" colspan="3">
												Order ID <span>PO000000128</span>
											</th>
										</tr>
										<tr>
											<th width="60%">
												Product
											</th>
											<th width="20%">
												Size
											</th>
											<th width="20%">
												quantity
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<p><span>ชื่อสินค้า&nbsp;:&nbsp;</span>'พวกเรา นนส.ทบ.' แบบที่ ๒</p>
												
											</td>
											<td>										
											</td>
											<td>
												
											</td>
										</tr>

										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="box-shipment">
						<table cellspacing="0">
							<tr>
								<td class="shipment-way text-center">
									<h3>Shipment Way</h3>
									<h3>Curry Express</h3>
								</td>
								<td class="shipment-id">
									<p>shipment ID here</p>
								</td>
							</tr>
						</table>						
					</div>
					<div class="from">
						<h3>From&nbsp;:&nbsp;Mubaza</h3>
						<p>231/136 soi 5 Udondusadee Road, Mak Khaeng, Mueang Udon Thani, Udon Thani, 41000</p>
					</div>
					<div class="box-customer">
						<div class="box-customer-header">
							<h1><span>To&nbsp;:&nbsp;</span>ศักรินทร์  ดาวร้าย</h1>
						</div>
						<div class="box-customer-address">
							<p>แฟรตสรรพวุธ 1</p>
                    		<p>818/99 ซอยสรรพวุธนิเวศน์ ถนนพระราม 5 แขวงถนนนครไชยศรี</p>
                    		<p>อ.เขตดุสิต&nbsp;จ.กรุงเทพมหานคร</p>
                    		<p>โทร&nbsp;0982873194</p>
						</div>
						<div class="zipcode">
							<h1>13000</h1>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td class="bottom">					
					<div class="box-caution">
						<h3>DO NOT ACCEPT IF SEAL IS BROKEN</h3>
						<p>all product at {{ config('profile.sitename') }} come with manufacturer's warranty where applicable</p>
						<p>
							Mubaza allows easy replcement for wrong size, color, quantity, style, manufaturing defects, damaged or significantlu different from product listing
						</p>
						<p><b>Customer Support&nbsp;</b>call&nbsp;:&nbsp;{{ config('profile.phone-primary') }},  <br>
						email&nbsp;:&nbsp;{{ config('profile.email') }}</p>
					</div>
				</td>
				<td class="bottom">
					<div class="box-barcode">
						<div class="order-id" >
							<h4>Order ID</h4>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<table class="page">
		<tbody>
			<tr>
				<td>
					<div class="box-order">
						<div class="box-order-header">
							<div class="box-logo">
								<img class="logo" src="{{ asset('images/logo-short.jpg') }}">
							</div>
							<div class="box-header">
								<h2>Shipment Details</h2>
								<p>track this shipment : http://www.{{ config('profile.sitename') }}</p>
							</div>
						</div>
						<div class="box-order-body">
							<div class="detail">
								<table class="table-detail" cellspacing="0">
									<thead>
										<tr>
											<th class="box-head" colspan="3">
												Order ID <span>PO000000128</span>
											</th>
										</tr>
										<tr>
											<th width="60%">
												Product
											</th>
											<th width="20%">
												Size
											</th>
											<th width="20%">
												quantity
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<p><span>ชื่อสินค้า&nbsp;:&nbsp;</span>'พวกเรา นนส.ทบ.' แบบที่ ๒</p>
												
											</td>
											<td>										
											</td>
											<td>
												
											</td>
										</tr>

										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
										<tr>
											<td>
												เสื้อยืดคอกลม มาตรฐาน สีเทา
											</td>
											<td>
												M
											</td>
											<td>
												5
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="box-shipment">
						<table cellspacing="0">
							<tr>
								<td class="shipment-way" width="65%">
									<h3><span>Shipment Way&nbsp;:&nbsp;</span>curry Express</h3>
								</td>
								<td class="shipment-id">
									<p>shipment ID here</p>
								</td>
							</tr>
						</table>						
					</div>
					<div class="from">
						<h3>From&nbsp;:&nbsp;Mubaza</h3>
						<p>231/136 soi 5 Udondusadee Road, Mak Khaeng, Mueang Udon Thani, Udon Thani, 41000</p>
					</div>
					<div class="box-customer">
						<div class="box-customer-header">
							<h1><span>To&nbsp;:&nbsp;</span>ศักรินทร์  ดาวร้าย</h1>
						</div>
						<div class="box-customer-address">
							<p>แฟรตสรรพวุธ 1</p>
                    		<p>818/99 ซอยสรรพวุธนิเวศน์ ถนนพระราม 5 แขวงถนนนครไชยศรี</p>
                    		<p>อ.เขตดุสิต&nbsp;จ.กรุงเทพมหานคร</p>
                    		<p>โทร&nbsp;0982873194</p>
						</div>
						<div class="zipcode">
							<h1>13000</h1>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td class="bottom">					
					<div class="box-caution">
						<h3>DO NOT ACCEPT IF SEAL IS BROKEN</h3>
						<p>all product at {{ config('profile.sitename') }} come with manufacturer's warranty where applicable</p>
						<p>
							Mubaza allows easy replcement for wrong size, color, quantity, style, manufaturing defects, damaged or significantlu different from product listing
						</p>
						<p><b>Customer Support&nbsp;</b>call&nbsp;:&nbsp;{{ config('profile.phone-primary') }},  <br>
						email&nbsp;:&nbsp;{{ config('profile.email') }}</p>
					</div>
				</td>
				<td class="bottom">
					<div class="box-barcode">
						<div class="order-id" >
							<h4>Order ID</h4>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
-->
</body>