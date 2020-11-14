@extends('backend.layouts.master')
@section('css')
<style>

#header-income {
	width:100%;
	height:50px;
	}

#table-income-detail {
	margin: 15px 0 0 0;
	}
#table-income-detail td:nth-child(2){
	text-align:left;
	padding-left:10px;
	}

#in1 {
	width:15px;
	height:15px;
	color:#61a9dc;
	display:inline;
	padding-right:15px;
	}
#in2 {
	width:15px;
	height:15px;
	color:#eaa228;
	display:inline;
	padding-right:15px;
	}

</style>
<script type="text/javascript">
	$(document).ready(function() { 
		$("#table-income-detail").tablesorter(); 
	});
	

// piechart	ใสจำนวนตรง value ได้เลยนะคะ
	var pieData = [
				// จัดซื้อ
				{
					value: 300,
					color:"#61a9dc",
					highlight: "#70c4ff",
					label: "เสื้อยืด"
				},
				{
					value: 100,
					color: "#E67E22",
					highlight: "#ff8c26",
					label: "เสื้อฮู้ด"
				},
				
				

			];

			window.onload = function(){
				var ctx = document.getElementById("chart-area").getContext("2d");
				window.myPie = new Chart(ctx).Pie(pieData);
			};

    $(document).ready(function(){
    $(".a-button-group-account-rate").click(function(){
        $(".a-button-group-account-rate.rate").removeClass("rate");
        $(this).addClass("rate");
    });
});		
</script>
@stop

@section('content')
<div id="header-income">
	<div class="col-md-6 ">
        <div class="header-account-date">
            <h4>ประจำวันที่ 21-04-2558 ถึง21-04-2558</h4>            
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="head-menu-account-group">
        	<!-- class here คือ acctive ของgroup นี้นะคะ -->
            <a class="btn head-menu-account " href="#">ภาพรวม</a>
            <a class="btn head-menu-account here" href="http://localhost/mubaza/public/backend-account-income">รายรับ</a>
            <a class="btn head-menu-account " href="http://localhost/mubaza/public/backend-account-expense">รายจ่าย</a>
        </div>
    </div>
    <div class="col-md-12 ">
    	
    	<div class="sub-menu-account">
        	<!--
        	<a class="a-sub-menu-account active" href="http://localhost/mubaza/public/backend-account-income">ทั้งหมด</a>
            <a class="a-sub-menu-account" href="http://localhost/mubaza/public/backend-account-income-purchase">จัดซื้อ</a>
            <a class="a-sub-menu-account" href="#">เงินเดือน</a>
            <a class="a-sub-menu-account" href="#">ขนส่ง</a>
            -->
        </div>
        
    </div>
</div>
<div class="col-md-12">
	<div class="account-detail">
    	<div class="col-md-4">
        	<div id="show-all">
                <div class="pricetag">
                    <h2>3647</h2><p>บาท</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
        	<div class="canvas-holder">
				<canvas id="chart-area" width="150" height="150"/>
			</div>
            <div class="canvas-detail">
            	<ul>
                	<li><i id="in1" class="fa fa-stop"></i>เสื้อยืด</li>
                    <li><i id="in2" class="fa fa-stop"></i>เสื้อฮู้ด</li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
        	<div class="button-group-account-rate btn-group-vertical">
            	<!-- class rate คือ acctive ของgroup นี้นะคะ -->
            	<a class="btn a-button-group-account-rate rate" href="#"><i class="fa fa-clock-o"></i>รายวัน</a>
                <a class="btn a-button-group-account-rate" href="#"><i class="fa fa-clock-o"></i>รายสัปดาห์</a>
                <a class="btn a-button-group-account-rate" href="#"><i class="fa fa-clock-o"></i>รายเดือน</a>
                <a class="btn a-button-group-account-rate" data-toggle="modal" href="#modal-date"><i class="fa fa-calendar"></i>เลือกวัน</a>
            </div>
        </div>
        <div class="col-md-12">
        	<table id="table-income-detail" class="table-radius">
            	<thead>
                	<tr>
                        <th width="15%">รหัสแคมเปญ</th>
                        <th width="30%">ชื่อแคมเปญ</th>
                        <th width="10%">เป้า/สั่ง</th>
                        <th width="15%">วันเริ่มแคมเปญ</th>
                        <th width="15%">ระยะเวลาที่เหลือ</th>
                        <th width="15%">กำไร</th>
                	</tr>
                </thead>
                <tbody>
                	<tr class="clickable-row" data-href="#">
                    	<td>001</td>
                        <td>asdedsdsads</td>
                        <td>100<span>/</span>190</td>
                        <td>10-04-2558</td>
                        <td>7</td>
                        <td>2345</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>002</td>
                        <td>asdedsdsads</td>
                        <td>100<span>/</span>190</td>
                        <td>10-04-2558</td>
                        <td>7</td>
                        <td>2345</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>003</td>
                        <td>asdedsdsads</td>
                        <td>100<span>/</span>190</td>
                        <td>10-04-2558</td>
                        <td>7</td>
                        <td>2345</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>004</td>
                        <td>asdedsdsads</td>
                        <td>100<span>/</span>190</td>
                        <td>10-04-2558</td>
                        <td>7</td>
                        <td>2345</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>005</td>
                        <td>asdedsdsads</td>
                        <td>100<span>/</span>190</td>
                        <td>10-04-2558</td>
                        <td>7</td>
                        <td>2345</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>006</td>
                        <td>asdedsdsads</td>
                        <td>100<span>/</span>190</td>
                        <td>10-04-2558</td>
                        <td>7</td>
                        <td>2345</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>007</td>
                        <td>asdedsdsads</td>
                        <td>100<span>/</span>190</td>
                        <td>10-04-2558</td>
                        <td>7</td>
                        <td>2345</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>008</td>
                        <td>asdedsdsads</td>
                        <td>100<span>/</span>190</td>
                        <td>10-04-2558</td>
                        <td>7</td>
                        <td>2345</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>009</td>
                        <td>asdedsdsads</td>
                        <td>100<span>/</span>190</td>
                        <td>10-04-2558</td>
                        <td>7</td>
                        <td>2345</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>0010</td>
                        <td>asdedsdsads</td>
                        <td>100<span>/</span>190</td>
                        <td>10-04-2558</td>
                        <td>7</td>
                        <td>2345</td>
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

<div class="modal fade" id="modal-date">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">เลือกช่วงเวลาที่ต้องการ</h4>
      </div>
      <div class="modal-body">
      		<div id="group-date">
                <div class="form-group form-inline">
                    <label for="date-for" class="control-label col-sm-1">จาก </label>
                    <div class="col-sm-5"> 
                        <input class="form-control" type="date" id="date-for">
                    </div>
    
                    <label for="date-to" class="control-label col-sm-1">ถึง </label>
                    <div class="col-sm-5"> 
                        <input class="form-control" type="date" id="date-to">
                    </div>
                </div>
          	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        <button type="sumit" class="btn btn-green" id="choose">เลือก</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop