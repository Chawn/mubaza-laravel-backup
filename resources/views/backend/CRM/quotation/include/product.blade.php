<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">รายการสินค้า</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<table class="table-product">
					<thead>
						<tr>
							<th width="35%">แบบเสื้อ</th>
							<th width="20%">สีเสื้อ</th>
							<th width="20%">ขนาด</th>
							<th width="15%">จำนวน (ตัว)</th>
							<th width="10%"></th>
						</tr>
					</thead>
					<tbody>
						@for ($i=0;$i<10;$i++)
						<tr>
							<td>
								เสื้อยืด คอกลม มาตรฐาน
							</td>
							<td>
								สีขาว
							</td>
							<td>
								M
							</td>
							<td>
								150
							</td>
							<td>
								฿1280
							</td>
						</tr>
						@endfor
						<tr class="tools">
							<td>
								<select name="type" id="type" class="form-control">
									<option value="0">กรุณาเลือกแบบเสื้อ</option>
									<option value="1">เสื้อยืด คอกลม มาตรฐาน</option>
									<option value="2">เสื้อยืด คอวี มาตรฐาน</option>
									<option value="3">เสื้อยืด คอกลม พรีเมี่ยม</option>
									<option value="4">เสื้อยืด คอวี พรีเมี่ยม</option>
									<option value="5">เสื้อโปโล</option>
									<option value="6">เสื้อฮู้ด</option>
								</select>
							</td>
							<td>
								<select name="color" id="color" class="form-control">
									<option value="0">เลือกสีเสื้อ</option>
									<option value="1">สีขาว</option>
									<option value="2">สีดำ</option>
									<option value="3">สีกรมท่า</option>
									<option value="4">สีเทาเข้ม</option>
								</select>
							</td>
							<td>
								<select name="type" id="type" class="form-control">
									<option value="0">เลือกขนาดเสื้อ</option>
									<option value="1">S</option>
									<option value="2">M</option>
									<option value="3">L</option>
									<option value="4">XL</option>
									<option value="5">XXL</option>
								</select>
							</td>
							<td>
								<input type="number" class="form-control">
							</td>
							<td>
								<button class="btn btn-success">
									<i class="fa fa-plus-circle"></i>&nbsp;เพิ่ม
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">ยอดรวม</h3>
	</div>
	<div class="panel-body">
		<div class="form-horizontal form-total">
			<div class="form-group">
				<label class="col-sm-4 control-label">รวมทั้งหมด&nbsp;:&nbsp;</label>
				<div class="col-sm-8">
					<p class="detail pull-right">1234</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label">ส่วนลดรวม(-)&nbsp;:&nbsp;</label>
				<div class="col-sm-8">
					<p class="detail pull-right">1234</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label">เงินหลังหักส่วนลด&nbsp;:&nbsp;</label>
				<div class="col-sm-8">
					<p class="detail pull-right">1234</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label">มูลค่าสินค้า&nbsp;:&nbsp;</label>
				<div class="col-sm-8">
					<p class="detail pull-right">1234</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label">ภาษีมูลค่าเพิ่ม&nbsp;:&nbsp;</label>
				<div class="col-sm-8">
					<p class="detail pull-right">1234</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label">จำนวนเงินทั้งสิ้น&nbsp;:&nbsp;</label>
				<div class="col-sm-8">
					<p class="detail pull-right">1234</p>
				</div>
			</div>
		</div>
	</div>
</div>