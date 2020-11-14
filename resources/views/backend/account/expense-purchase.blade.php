@extends('backend.layouts.master')
@section('css')
<style>

#header-expense-purchase {
	width:100%;
	height:50px;
	}

#table-expense-purchase-detail {
	margin: 15px 0 0 0;
	}
#add-purchase {
	width:210px;
	margin:15px 0 0 15px;
	}
#add-purchase-collapse {
	margin:15px 0 0 0;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() { 
		$("#table-expense-purchase-detail").tablesorter(); 
	});

    $(document).ready(function(){
    $(".a-button-group-account-rate").click(function(){
        $(".a-button-group-account-rate.rate").removeClass("rate");
        $(this).addClass("rate");
    });
});
</script>
@stop

@section('content')
<div id="header-expense-purchase">
	<div class="col-md-6 ">
        <div class="header-account-date">
            <h4>ประจำวันที่ 21-04-2558 ถึง21-04-2558</h4>            
        </div>
    </div>
    <div class="col-md-6 ">
        <!-- "here" is active of menu-account-group class -->
        <div class="head-menu-account-group">
            <a class="btn head-menu-account " href="#">ภาพรวม</a>
            <a class="btn head-menu-account" href="http://localhost/mubaza/public/backend-account-income">รายรับ</a>
            <a class="btn head-menu-account here" href="http://localhost/mubaza/public/backend-account-expense">รายจ่าย</a>
        </div>
    </div>
    <div class="col-md-12 ">
        <!-- "this" is active of a-sub-menu-account class -->
    	<div class="sub-menu-account">
        	<a class="a-sub-menu-account" href="http://localhost/mubaza/public/backend-account-expense">ทั้งหมด</a>
            <a class="a-sub-menu-account this" href="http://localhost/mubaza/public/backend-account-expense-purchase">จัดซื้อ</a>
            <a class="a-sub-menu-account" href="#">เงินเดือน</a>
            <a class="a-sub-menu-account" href="#">ขนส่ง</a>
        </div>
    </div>
</div>
<div class="col-md-12">
	<div class="account-detail">
    	<div class="col-md-4">
        	<div id="show-all">
                <div class="pricetag">
                    <h2>1234</h2><p>บาท</p>
                </div>
                <a id="add-purchase" class="btn btn-default" href="#add-purchase-collapse" data-toggle="collapse" aria-expanded="false" aria-controls="add-collapse">เพิ่มสินค้าที่จัดซื้อ</a>
            </div>
        </div>
        <div class="col-md-4">
        	
        </div>
        <div class="col-md-4">
        	<div class="button-group-account-rate btn-group-vertical">
            	<a class="btn a-button-group-account-rate rate" href="#"><i class="fa fa-clock-o"></i>รายวัน</a>
                <a class="btn a-button-group-account-rate" href="#"><i class="fa fa-clock-o"></i>รายสัปดาห์</a>
                <a class="btn a-button-group-account-rate" href="#"><i class="fa fa-clock-o"></i>รายเดือน</a>
                <a class="btn a-button-group-account-rate" href="#"><i class="fa fa-calendar"></i>เลือกวัน</a>
            </div>
            
        </div>
        <div class="col-md-12">
        	<div class="collapse" id="add-purchase-collapse">
                <div class="well">
                    <h4>เพิ่มสินค้าที่จัดซื้อ</h4>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="inputBillNO" class="col-sm-2 control-label">หมายเลขใบสั่งซื้อ</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inputBillNO" placeholder="หมายเลขใบสั่งซื้อ">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDate" class="col-sm-2 control-label">วันที่สั่งซื้อ</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="inputDate" placeholder="วันที่สั่งซื้อ">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputSupplier" class="col-sm-2 control-label">ซื้อจาก</label>
                            <div class="col-sm-4">
                                <select id="inputSupplier" class="form-control">
                                    <option value="1">บริษัท A</option>
                                    <option value="2">บริษัท B</option>
                                    <option value="3">บริษัท C</option>
                                </select>
                            </div>                            
                        </div>
                        <div class="form-group">
                            <label for="inputItem" class="col-sm-2 control-label">สินค้า</label>
                            <div class="col-sm-10">
                                <select id="inputItem" class="input-border">
                                    <option value="1">เสื้อยืด</option>
                                    <option value="2">เสื้อฮุด</option>                            
                                </select>
                                <select class="input-border">
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="XXL">XXL</option>
                                </select>
                                <select class="input-border">
                                    <option value="white">ขาว</option>
                                    <option value="black">ดำ</option>
                                    <option value="gray">เทา</option>
                                    <option value="green">เขียว</option>
                                    <option value="pink">ชมพู</option>
                                    <option value="blue">ฟ้า</option>
                                    <option value="yellow">เหลือง</option>
                                </select>
                                <select class="input-border">
                                    <option value="male">ผู้ชาย</option>
                                    <option value="female">ผู้หญิง</option>
                                </select>
                            </div>
                        </div><!-- end form-group -->
                        <div class="form-group">
                            <label for="inputFile" class="col-sm-2 control-label">ไฟล์แนบ</label>
                            <div class="col-sm-10">
                                <input id="inputFile" type="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                <button class="btn btn-green">บันทึก</button>
                            </div>
                        </div>
                    </form>
                </div><!-- end well -->
            </div><!-- end collapse -->
        </div>
        <div class="col-md-12">
        	<table id="table-expense-purchase-detail" class="table-radius">
            	<thead>
                	<tr>
                    	<th width="5%">ลำดับ</th>
                		<th width="15%">หมายเลขใบสั่งซื้อ</th>
               		 	<th width="10%">วันที่</th>                
                		<th width="45%">รายการ</th>
                		<th width="10%">จำนวน</th>
                		<th width="15%">เป็นเงิน(บาท)</th>
                    </tr>
                </thead>
                <tbody>
                	<tr class="clickable-row" data-href="#">
                    	<td>001</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>1500</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>002</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>2500</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>003</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>3000</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>004</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>4000</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>005</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>5500</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>006</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>6000</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>007</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>7000</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>008</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>8000</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>009</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>9000</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>0010</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>1010</td>
                    </tr>
                </tbody>
           	</table>
            <div class="div-pagination">
                <div class="navbar-left">
                    <p>แสดง 10 จาก 109</p>
                </div>
                <div class="navbar-right">
                    <div class="a-pagination">
                        <a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>   
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#">4</a>
                        <a href="#">5</a>
                        <a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
                    </div>
                </div>
            </div><!-- end div-pagination -->
        </div>
    </div><!-- end account-detail -->
</div><!-- col-md-12 -->
<div class="col-md-12 account-clear"></div>
@stop