<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ $title }}</title>
	<style type="text/css">
		body {
			font-family: 'Tahoma';
			font-size: 12px;
			margin:0;
			padding:0;
			width: 974px;
			text-align: center;
		}
		h2 {
			margin-top: 15px;
		}
		table {
			border-spacing: 0px;
			text-align: center;
			margin: 10px 0 10px 0px;
			font-size: 14px;
			margin-left:auto;
			margin-right:auto;
		}
		tr {
			height: 35px;

		}
		th {
			width: 100px;
			height: 35px;
			border-bottom: 1px solid #000;
			border-left: 1px solid #000;
		}
		th:last-child {
			border-right: 1px solid #000;
		}
		td {
			width: 100px;
			height: 35px;
			border-bottom: 1px solid #000;
			border-left: 1px solid #000;
			border-right: none;
		}
		td:first-child {
			font-weight: bold;
		}
		td:last-child {
			border-right: 1px solid #000;
		}
		th:first-child {

		}
		.tshirt-type {
			font-size: 18px;:;
			font-weight: normal;
			vertical-align: middle;
			margin-top: 5px;
		}

		@media all
		{
			.page-break { display:none; }
		}
		@media print
		{
			.page-break { display:block;height:1px; page-break-after:always; }
		}
	</style>
</head>
<body>
<h2>ใบรายการผลิต แคมเปญ {{ $campaign->title }}</h2>
<!-- ตารางได้ 36 แถว แล้ว page break -->
@foreach($ordered_product['items'] as $product)
	<table>
		<thead>
		<tr>
			<th colspan="3">
				<img src="/{{ $campaign->design->image_front_preview_thmb }}" alt="">
			</th>
			<th>&nbsp;</th>
			<th colspan="3">
				<img src="/{{ $campaign->design->image_back_preview_thmb }}" alt="">
			</th>
		</tr>
		<tr><th colspan="7" class="tshirt-type" style="border-top:1px solid #000">{{ $product['name'] }}</th></tr>
		<tr>
			<th>สีเสื้อ</th>
			<th>XS</th>
			<th>S</th>
			<th>M</th>
			<th>L</th>
			<th>XL</th>
			<th>XXL</th>
		</tr>
		</thead>
		<tbody>
		@foreach($product['colors'] as $key => $color)
			<tr>
				<td>{{ $key }}</td>
				<td>{{ isset($color['sizes']['XS']) ? $color['sizes']['XS'] : '0' }}</td>
				<td>{{ isset($color['sizes']['S']) ? $color['sizes']['S'] : '0' }}</td>
				<td>{{ isset($color['sizes']['M']) ? $color['sizes']['M'] : '0' }}</td>
				<td>{{ isset($color['sizes']['L']) ? $color['sizes']['L'] : '0' }}</td>
				<td>{{ isset($color['sizes']['XL']) ? $color['sizes']['XL'] : '0' }}</td>
				<td>{{ isset($color['sizes']['XXL']) ? $color['sizes']['XXL'] : '0' }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@endforeach
<div class="page-break"></div>
</body>
</html>