@extends('layouts.help')
@section('css')
<style>
	.table{
		width: 100%;
		margin: 25px 0;
		background: #fff;
		text-align: center;
		border-color: #000;
	}
	.table thead tr th{
		text-align: center;
		background: #111;
		border: 2px solid #000;
		color: #fff;
	}
	.table tbody tr td{
		text-align: center;
		border: 2px solid #000;
	}
	.panel{
		margin: 25px 0;
	}
	.panel img{
		width: 80%;
	}
	@media(max-width: 767px){
		.panel img{
			width: 100%;
		}
	}
</style>
@stop
@section('content')
<div id="artcle">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-body text-center">
				<img src="{{asset('images/help/howtosize2.jpg')}}">
			</div>
		</div>
		
	</div>
	
	<div class="col-md-6 col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<div class="page-header">
					<h4>ขนาดเสื้อยืด</h4>
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>
								ขนาด (size)
							</th>
							<th>
								รอบอก (Chest)
							</th>
							<th>
								ความยาว (Length)
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								S
							</td>
							<td>
								
							</td>
							<td>
								
							</td>
						</tr>
						<tr>
							<td>
								M
							</td>
							<td>
								32"
							</td>
							<td>
								
							</td>
						</tr>
						<tr>
							<td>
								M2
							</td>
							<td>
								
							</td>
							<td>
								
							</td>
						</tr>
						<tr>
							<td>
								L
							</td>
							<td>
								
							</td>
							<td>
								
							</td>
						</tr>
						<tr>
							<td>
								XL
							</td>
							<td>
								
							</td>
							<td>
								
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>	
	</div>
	<div class="col-md-6 col-sm-12">
		<div class="panel">
			<div class="panel-body">
				<div class="page-header">
					<h4>ขนาดเสื้อยืด</h4>
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>
								ขนาด (size)
							</th>
							<th>
								รอบอก (Chest)
							</th>
							<th>
								ความยาว (Length)
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								S
							</td>
							<td>
								
							</td>
							<td>
								
							</td>
						</tr>
						<tr>
							<td>
								M
							</td>
							<td>
								32"
							</td>
							<td>
								
							</td>
						</tr>
						<tr>
							<td>
								M2
							</td>
							<td>
								
							</td>
							<td>
								
							</td>
						</tr>
						<tr>
							<td>
								L
							</td>
							<td>
								
							</td>
							<td>
								
							</td>
						</tr>
						<tr>
							<td>
								XL
							</td>
							<td>
								
							</td>
							<td>
								
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>	
	</div>		
</div>
<!-- end PAGE -->
@stop