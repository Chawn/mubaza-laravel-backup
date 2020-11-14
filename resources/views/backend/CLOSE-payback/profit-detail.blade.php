@extends('backend.layouts.master')
<link rel="stylesheet" href="{{ asset('css/new-backend.css') }}">
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header">
				<div class="box-title">
					<h3 class="box-title">รายการยื่นคำขอ #000001</h3>
				</div>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-sm-6">
						<b>ข้อมูลการติดต่อ</b>
						<br>ชื่อ-นามสกุล(จริง):&nbsp;นายศักรินทร์ มีพวกมาก
						<br>ชื่อที่ใช้แสดง:&nbsp;<a href="#">ศักรินทร์</a>
						<br>เบอร์โทร:&nbsp;095-421-2774
						<br>อีเมลล์:&nbsp;chawput@gmail.com
					</div>

					<div class="col-sm-6">
						<strong>วันที่ยื่นคำร้อง:&nbsp;</strong>{{ Carbon::now()->format('d/m/Y')}}
						<br>
						<strong>กำหนดการ:&nbsp;</strong>{{ Carbon::now()->format('d/m/Y') }}
					</div>
				</div>
				<br>
				<div class="well">
				    <div class="row">
				        <div class="col-sm-6">
				            <h2 class="text-center"><small>จำนวนเงิน </small> 24,000 บาท</h2>
				            <p class="text-center">
				            	<button class="btn btn-success btn-xl" data-toggle="modal" data-target="#modal-profit-detail">ยืนยันการจ่ายรายได้</button>

				            </p>
				        </div>
				        <div class="col-sm-6">
				            <ul class="list-group">
				                <li class="list-group-item">
				                    <strong class="text-info">ช่วงเวลา: </strong>
				                    30/12/2557 - 30/12/2558
				                </li>
				                <li class="list-group-item">
				                    <strong class="text-info">ส่วนแบ่งรายได้: </strong> 24,000 บาท<br>
				                </li>
				                <li class="list-group-item">
				                    <strong class="text-info">ภาษีหัก ณ ที่จ่าย (7%): </strong> 0 บาท<br>
				                </li>
				            </ul>
				        </div>
				    </div>
				</div>
				
				<h3>ประวัติการขาย</h3>
				<table id="table-profit-detail" class="table tablesorter table-bordered table-striped dataTable">
                    <thead>
                        <tr>
                            <th>สินค้า</th>
                            <th>ราคาต่อหน่วย</th>
                            <th>ยอดขายรวม</th>
                            <th>ส่วนแบ่ง</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>BLACK HAWK DOWN</td>
                            <td>฿250</td>
                            <td>฿25,000</td>
                            <td>฿6,000 (30% - 35%)</td>
                            <td>
                            	<a href="#"><i class="fa fa-file-text-o"></i></a>
                            </td>
                        </tr> 
						<tr>
                            <td>CHUNJING</td>
                            <td>฿250</td>
                            <td>฿25,000</td>
                            <td>฿6,000 (30% - 35%)</td>
                            <td>
                            	<a href="#"><i class="fa fa-file-text-o"></i></a>
                            </td>
                        </tr> 
                        <tr>
                            <td>THAILAND STRONGER</td>
                            <td>฿250</td>
                            <td>฿25,000</td>
                            <td>฿6,000 (30% - 35%)</td>
                            <td>
                            	<a href="#"><i class="fa fa-file-text-o"></i></a>
                            </td>
                        </tr> 
                        <tr>
                            <td>JUST DO IT</td>
                            <td>฿250</td>
                            <td>฿25,000</td>
                            <td>฿6,000 (30% - 35%)</td>
                            <td>
                            	<a href="#"><i class="fa fa-file-text-o"></i></a>
                            </td>
                        </tr> 
                    </tbody>
                </table>
                <hr>
                <div class="row">
                	<div class="col-sm-6">
                		<button class="btn btn-default-shadow">
                            <i class="fa fa-print"></i> 
                            พิมพ์รายงานอย่างละเอียด
                        </button>
                        <button class="btn btn-default-shadow">
                            <i class="fa fa-print"></i> 
                            พิมพ์ใบร้องขอ
                        </button>
                	</div>
                	<div class="col-sm-6 text-right">
                	</div>
                </div>
			</div>
		</div>
		<div class="box">
		</div>
	</div>
</div>

<div id="modal-profit-detail" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4>กรอกรายละเอียดการโอนเงิน</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-3 control-label">โอนจาก</label>
					    <div class="col-sm-9">
					    	<select name="mbank" id="mbank" class="form-control">
					    		<option value="bangkokbank">ธนาคารกรุงเทพ</option>
								<option value="kbank">ธนาคารกสิกรไทย</option>
								<option value="ktb">ธนาคารกรุงไทย</option>
								<option value="tmb">ธนาคารทหารไทย</option>
					    	</select>
					    </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">ธนาคารที่โอนเข้า</label>
					    <div class="col-sm-9">
					    	<input type="text" class="form-control" placeholder="ธนาคารที่โอนเข้า">
					    </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">จำนวนเงิน</label>
					    <div class="col-sm-9">
					    	<input type="number" class="form-control" placeholder="จำนวนเงิน">
					    </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">วันที่</label>
					    <div class="col-sm-9">
					    	<input type="date" class="form-control" >
					    </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">เวลา</label>
					    <div class="col-sm-9">
					    	<input type="time" class="form-control" >
					    </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">ไฟล์แนบ</label>
					    <div class="col-sm-9">
					    	<input type="file" class="form-control" >
					    </div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
        		<a type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#modal-auth-staff">ยืนยัน</a>
			</div>
		</div>
	</div>
</div>
<div id="modal-auth-staff" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4>กรอกรหัสพนักงานเพื่อยืนยัน</h4>
			</div>
			<div class="modal-body">
				<input type="text" class="form-control">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
				<button class="btn btn-primary">ยืนยัน</button>
			</div>
		</div>
	</div>
</div>
@stop