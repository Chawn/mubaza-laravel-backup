@extends('backend.layouts.master')
<link rel="stylesheet" href="{{ asset('css/crm.css') }}">

@section('script')
<script>
	$(document).ready(function() {
			$('.tools-group').hide();
			$('.docbox').click(function(e){
				if (!$(e.target).hasClass('btn-show') & !$(e.target).hasClass('customer-name')){
					if ($(this).find('input:checkbox[name=selectQUO]').is(":checked")) {
						$(this).find('input:checkbox[name=selectQUO]').attr("checked", false);
						$('.tools-group').slideUp('slow');
					}else {
					    $(this).find('input:checkbox[name=selectQUO]').prop("checked", true);
					    $('.tools-group').slideDown('slow');			    
					}
				}
					
			});
				
	});
</script>
@stop
@section('css')
<style>
	
</style>
@stop
@section('content')
<div class="row">
	<div class="col-md-3 pull-right">
		<div class="box">
			<div class="box-body box-menu">
				<div class="box-sub">
					<div class="sub-header">
						<h4><i class="fa fa-filter"></i>&nbsp;เครื่องเมือ 
							<span class="btn-transparent pull-right" data-toggle="collapse" data-target="#btn-tools-group" aria-expanded="false" aria-controls="filter-menu">
								<i class="fa fa-angle-down"></i>
							</span>
						</h4>
					</div>
					
					<div id="btn-tools-group" class="btn-tools-group collapse in">
						<a href="{{url('backend-quotation-create')}}" class="btn btn-tools btn-success">สร้าง</a>
						<a href="#" class="btn btn-tools btn-warning">แก้ไข</a>
						<a href="#" class="btn btn-tools btn-default">ลบ</a>
					</div>
				</div>
					

				<ul class="list-group tools-group">
					<li class="list-group-item">
						<label>เมนู</label>
						<ul class="list-group sub-list">
							<li class="list-group-item">
								<a href="{{url('backend-PO-create')}}">
									<i class="fa fa-file-text-o"></i>
									สร้างใบสั่งซื้อ
								</a>
							</li>
							<li class="list-group-item">
								<a href="#">
									<i class="fa fa-file-text-o"></i>
									สร้างใบกับกับภาษี
								</a>
							</li>
							<li class="list-group-item">
								<a href="#">
									<i class="fa fa-files-o"></i>
									คัดลอก
								</a>
							</li>
							<li class="list-group-item">
								<a href="#">
									<i class="fa fa-users"></i>
									มอบหมาย
								</a>
							</li>
						</ul>
					</li>
					<li class="list-group-item">
						<label>สถานะ</label>
						<ul class="list-group sub-list">
							<li class="list-group-item">
								<a href="#">
									<i class="fa fa-file-text-o"></i>
									เปิดใช้งานใบสั่งซื้อ
								</a>
							</li>
							<li class="list-group-item">
								<a href="#">
									<i class="fa fa-file-text-o"></i>
									พักใบสั่งซื้อ
								</a>
							</li>
							<li class="list-group-item">
								<a href="#">
									<i class="fa fa-files-o"></i>
									ยกเลิกใบสั่งซื้อ
								</a>
							</li>
						</ul>
					</li>
				</ul>

				<div class="box-sub">
					<div class="sub-header">
						<h4><i class="fa fa-filter"></i>&nbsp;ตัวกรองข้อมูลใบเสนอราคา 
							<span class="btn-transparent pull-right" data-toggle="collapse" data-target="#filter-menu" aria-expanded="false" aria-controls="filter-menu">
								<i class="fa fa-angle-down"></i>
							</span>
						</h4>
					</div>						
					<ul id="filter-menu" class="list-group collapse in">
						<li class="list-group-item">
							<a href="#">ทั้งหมด <span class="badge pull-right">42</span></a>
						</li>
						<li class="list-group-item">
							<a href="#">วันนี้ <span class="badge pull-right">42</span></a>
						</li>
						<li class="list-group-item">
							<a href="#">ใบเสนอราคาเกิดวันกำหนด<span class="badge pull-right">42</span></a>
						</li>
						<li class="list-group-item border-none">
							<a href="#">สถานะของใบเสนอราคา<span class="badge pull-right">42</span></a>
							<ul class="list-group sub-list">
								<li class="list-group-item">
									<a href="#">รออนุมัติ<span class="badge pull-right">42</span></a>
								</li>
								<li class="list-group-item">
									<a href="#">อนุมัติ<span class="badge pull-right">42</span></a>
								</li>
								<li class="list-group-item">
									<a href="#">ปิด<span class="badge pull-right">42</span></a>
								</li>
								<li class="list-group-item">
									<a href="#">ยกเลิก<span class="badge pull-right">42</span></a>
								</li>
							</ul>
						</li>
						<li class="list-group-item border-none">
							<a href="#">ทำใบสั่งขาย<span class="badge pull-right">42</span></a>
							<ul class="list-group sub-list">
								<li class="list-group-item">
									<a href="#">ปิด<span class="badge pull-right">42</span></a>
								</li>
								<li class="list-group-item">
									<a href="#">ยกเลิก<span class="badge pull-right">42</span></a>
								</li>
							</ul>
						</li>
						<li class="list-group-item border-none">
							<a href="#">ทำใบกำกับภาษี<span class="badge pull-right">42</span></a>
							<ul class="list-group sub-list border-none">
								<li class="list-group-item">
									<a href="#">รอชำระเงิน<span class="badge pull-right">42</span></a>
								</li>
								<li class="list-group-item">
									<a href="#">ชำระเงินเรียบร้อยแล้ว<span class="badge pull-right">42</span></a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>		
	</div>
	<div class="col-md-9">
		<div class="box">
			<div class="box-header">
				<div class=" form-inline">
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="dataTables_length" id="example1_length">
                                <label>แสดง
                                    <select name="paginate_select" id="paginate-select" class="form-control input-sm">
                                        <option value="http://localhost/mubaza-laravel/public/backend/order/12">12 รายการ</option>
                                        <option value="http://localhost/mubaza-laravel/public/backend/order/24">24 รายการ</option>
                                        <option value="http://localhost/mubaza-laravel/public/backend/order/36">36 รายการ</option>
                                    </select> ต่อหน้า
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div id="example1_filter" class="dataTables_filter">
                                <div class="pull-right">
                                	<form action="http://localhost/mubaza-laravel/public/backend/order" method="get">
                                	<label>ค้นหา:</label>  
                                	<div class="input-group">
                                		<div class="input-group-btn">
                                			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ทั้งหมด<span class="caret"></span></button>
                                			<ul class="dropdown-menu">
                                				<li><a href="#">ลูกค้า</a></li>
                                				<li><a href="#">เลขที่ใบเสนอราคา</a></li>
                                				<li><a href="#">รหัสลูกค้า</a></li>     
                                				<li><a href="#">ประเภทลูกค้า</a></li>
                                				<li><a href="#">วันที่ออกใบเสนอราคา</a></li>
                                				<li><a href="#">มีผลถึงวันที่</a></li>
                                				<li><a href="#">สถานะ</a></li>
                                				<li><a href="#">พัก/ยกเลิก</a></li>
                                				<li><a href="#">จำนวนวันเครดิต</a></li>
                                				<li><a href="#">จำนวนเงินทั้งสิ้น</a></li>
                                				<li><a href="#">วันที่แก้ไขล่าสุด</a></li>
                                				<li><a href="#">แก้ไขล่าสุดโดย</a></li>
                                				<li><a href="#">วันที่สร้าง</a></li>
                                				<li><a href="#">สร้างโดย</a></li>
                                			</ul>
                                		</div><!-- /btn-group -->
                                		<input type="text" class="form-control" name="q" placeholder="">
                                		<div class="input-group-btn">
                                			<button class="btn btn-default">
	                                			<i class="fa fa-search"></i>ค้น
	                                		</button>
                                		</div>
                                	</div>	
                                	</form>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
			<div class="box-body">				
				<div class="row">
					<div class="col-md-4 col-nonpadding">
						<div class="docbox">
							<div class="select">
								<input type="checkbox" name="selectQUO">
								<label for="selectQUO"><i class="fa fa-check-circle"></i></label>
							</div>						
							<div class="docbox-head">								
								<div class="docbox-header">
									<h4>QUO0000001</h4>
									<p>12-12-2558</p>
									<p><a class="customer-name" href="#">คุณ&nbsp;ศักรินทร์</a></p>
									<p class="">ลูกค้าใหม่</p>
								</div>
							</div>
							<div class="docbox-detail">
								<table>
									<tr>
										<td>2</td>
										<td>เสื้อยืดมาตรฐาน คอกลม สีขาว</td>
									</tr>
									<tr>
										<td>2</td>
										<td>เสื้อยืดมาตรฐาน คอกลม สีขาว</td>
									</tr>
									<tr>
										<td>2</td>
										<td>เสื้อยืดมาตรฐาน คอกลม สีขาว</td>
									</tr>
									<tr>
										<td>2</td>
										<td>เสื้อยืดมาตรฐาน คอกลม สีขาว</td>
									</tr>
								</table>
							</div>
							<div class="docbox-total">
								<h4>ยอดรวม 128,000 บาท</h4>
							</div>
							<div class="docbox-foot">
								<p>พนักงาน<span class="pull-right">พิงกี้วิงกี้</span></p>
							</div>
							<div class="showmore">
								<a id="" class="btn btn-success btn-show">ดูรายละเอียดเพิ่มเติม</a>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-nonpadding">
						<div class="docbox">	
							<div class="select">
								<input type="checkbox" name="selectQUO">
								<label for="selectQUO"><i class="fa fa-check-circle"></i></label>
							</div>					
							<div class="docbox-head">
								
								<div class="docbox-header">
									<h4>QUO0000001</h4>
									<p>12-12-2558</p>
									<p><a class="customer-name" href="#">คุณ&nbsp;ศักรินทร์</a></p>
									<p class="org">ลูกค้าองค์กร</p>
								</div>
							</div>
							<div class="docbox-detail">
								<table>
									<tr>
										<td>2</td>
										<td>เสื้อยืดมาตรฐาน คอกลม สีขาว</td>
									</tr>
									<tr>
										<td>2</td>
										<td>เสื้อยืดมาตรฐาน คอกลม สีขาว</td>
									</tr>
									<tr>
										<td>2</td>
										<td>เสื้อยืดมาตรฐาน คอกลม สีขาว</td>
									</tr>
									<tr>
										<td>2</td>
										<td>เสื้อยืดมาตรฐาน คอกลม สีขาว</td>
									</tr>
								</table>
							</div>
							<div class="docbox-total">
								<h4>ยอดรวม 128,000 บาท</h4>
							</div>
							<div class="docbox-foot">
								<p>พนักงาน<span class="pull-right">พิงกี้วิงกี้</span></p>
							</div>
							<div class="showmore">
								<a id="" class="btn btn-success btn-show">ดูรายละเอียดเพิ่มเติม</a>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-nonpadding">
						<div class="docbox">
							<div class="select">
								<input type="checkbox" name="selectQUO">
								<label for="selectQUO"><i class="fa fa-check-circle"></i></label>
							</div>						
							<div class="docbox-head">								
								<div class="docbox-header">
									<h4>QUO0000001</h4>
									<p>12-12-2558</p>
									<p><a class="customer-name" href="#">คุณ&nbsp;ศักรินทร์</a></p>
									<p class="shop">ลูกค้าร้านค้า</p>
								</div>
							</div>
							<div class="docbox-detail">
								<table>
									<tr>
										<td>2</td>
										<td>เสื้อยืดมาตรฐาน คอกลม สีขาว</td>
									</tr>
									<tr>
										<td>2</td>
										<td>เสื้อยืดมาตรฐาน คอกลม สีขาว</td>
									</tr>
									<tr>
										<td>2</td>
										<td>เสื้อยืดมาตรฐาน คอกลม สีขาว</td>
									</tr>
									<tr>
										<td>2</td>
										<td>เสื้อยืดมาตรฐาน คอกลม สีขาว</td>
									</tr>
								</table>
							</div>
							<div class="docbox-total">
								<h4>ยอดรวม 128,000 บาท</h4>
							</div>
							<div class="docbox-foot">
								<p>พนักงาน<span class="pull-right">พิงกี้วิงกี้</span></p>
							</div>
							<div class="showmore">
								<a id="" class="btn btn-success btn-show">ดูรายละเอียดเพิ่มเติม</a>
							</div>
						</div>
					</div>
				</div>

                
                <div class="div-pagination">
                    <div class="navbar-right">
                        
                    </div>
                </div>
			</div>
		</div>
	</div>
	
</div>
@stop