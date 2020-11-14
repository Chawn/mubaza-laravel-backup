@extends('backend.layouts.master')
<link rel="stylesheet" href="{{ asset('css/crm.css') }}">
@section('script')
<script>
	$(document).ready(function() {
		$('.open-datetimepicker').click(function(event){
		    event.preventDefault();
		    $('#datetimepicker').click();
		});

		 $("#quo-create").datepicker({ 
            changeMonth: true, 
            changeYear: true,
            dateFormat: 'dd/mm/yy', 
            isBuddhist: true, 
            dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
            dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
            monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
            monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']
        });

		$('.table-modal tbody tr').click(function() {
			$(this).find('input:radio').prop('checked', true);
		});
	});
</script>
@stop

@section('content')
<div class="row">
	<div class="col-md-3 pull-right">
		<div class="box">
			<div class="box-body box-menu">
				<div class="box-sub">
					<div class="sub-header">
						<h4><i class="fa fa-cog"></i>&nbsp;เครื่องมือ 
							<span class="btn-transparent pull-right" data-toggle="collapse" data-target="#quo-menu" aria-expanded="false" aria-controls="filter-menu">
								<i class="fa fa-angle-down"></i>
							</span>
						</h4>
					</div>					
					<div id="quo-menu" class="collapse in">				
						<ul class="list-group">
							<li class="list-group-item">
								<button class="btn btn-crm btn-primary">
									<span></span>ดูตัวอย่าง 
								</button>
							</li>
							<li class="list-group-item">
								<button class="btn btn-crm btn-success">
									<span></span>บันทึก 
								</button>
							</li>
							<li class="list-group-item">
								<button class="btn btn-crm btn-default">
									<span></span>ยกเลิก 
								</button>
							</li>
						</ul>						
					</div>						
				</div>

				<div class="box-sub">
					<div class="sub-header">
						<h4><i class="fa fa-file-text-o"></i>&nbsp;สร้าง 
							<span class="btn-transparent pull-right" data-toggle="collapse" data-target="#create-menu" aria-expanded="false" aria-controls="filter-menu">
								<i class="fa fa-angle-down"></i>
							</span>
						</h4>
					</div>
					<div id="create-menu" class="collapse in">
						<ul class="list-group">
							<li class="list-group-item">
								<a href="#">ลูกค้า (Contact)</a>
							</li>
							<li class="list-group-item">
								<a href="#">ลูกค้า (Account)</a>
							</li>
							<li class="list-group-item">
								<a href="#">โอกาสทางการขาย</a>
							</li>
							<li class="list-group-item">
								<a href="#">สินค้า</a>
							</li>
							<li class="list-group-item">
								<a href="#">เงื่อนไขการชำระเงิน</a>
							</li>
							<li class="list-group-item">
								<a href="#">กระบวนการจัดซื้อ</a>
							</li>
							<li class="list-group-item">
								<a href="#">วิธีการขนส่ง</a>
							</li>
							<li class="list-group-item">
								<a href="#">เงื่อนไขการขนส่ง</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
				
		</div>
	</div>
	<div class="col-md-9">
		<div class="box">
			<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<ul class="nav nav-square" role="tablist">
							<li role="presentation" class="active"><a href="#information" aria-controls="information" role="tab" data-toggle="tab">ข้อมูลเบื้องต้น</a></li>
							<li role="presentation"><a href="#product" aria-controls="product" role="tab" data-toggle="tab">สินค้า</a></li>
							<li role="presentation"><a href="#address" aria-controls="address" role="tab" data-toggle="tab">ที่อยู่รับใบแจ้งหนี้</a></li>
							<li role="presentation"><a href="#shiping-address" aria-controls="shiping-address" role="tab" data-toggle="tab">ที่อยู่จัดส่ง</a></li>
							<li role="presentation"><a href="#detail" aria-controls="detail" role="tab" data-toggle="tab">คำอธิบาย</a></li>
						</ul>
						<div class="tab-content">
							<!-- ##### ข้อมูลเบื้องต้น ##### -->
							
							<div role="tabpanel" class="tab-pane active" id="information">
								@include('backend.CRM.quotation.include.information')
								
							</div>

							<!-- ##### สินค้า ##### -->
							<div role="tabpanel" class="tab-pane" id="product">
								@include('backend.CRM.quotation.include.product')
								
							</div>

							<!-- ##### ที่อยู่รับใบแจ้งหนี้ ##### -->

							<div role="tabpanel" class="tab-pane" id="address">
								@include('backend.CRM.quotation.include.billaddress')
							</div>

							<!-- ##### ที่อยู่จัดส่ง ##### -->
							<div role="tabpanel" class="tab-pane" id="shiping-address">
								@include('backend.CRM.quotation.include.shipingaddress')
							</div>

							<!-- ##### คำอธิบาย ##### -->
							<div role="tabpanel" class="tab-pane" id="detail">
								@include('backend.CRM.quotation.include.detail')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop