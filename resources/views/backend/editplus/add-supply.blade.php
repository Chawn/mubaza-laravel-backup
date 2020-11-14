@extends('backend.layouts.master')
@section('css')
<style>
#table-supply {
	margin: 20px 0 0 0;
	}
</style>
<script type="text/javascript">
	$(function() {
        $("table tr:nth-child(odd)").addClass("odd-row");
	});
	$(document).ready(function() { 
		$("#table-supply").tablesorter(); 
	}); 

</script>
@stop
@section('content')
<div>
	<h3>ซัพพลาย</h3>
    <div class="add-header">         	
		<a class=" navbar-right" data-toggle="collapse" href="#add-supply-collapse" aria-expanded="false" aria-controls="add-collapse"><i class="fa fa-plus">&nbsp;เพิ่มซัพพลาย</i></a> <br>
    </div>
    <div class="collapse" id="add-supply-collapse">
		<div class="well"> 
        	<h4>เพิ่มซัพพลาย</h4> 
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="inputSname" class="col-sm-2 control-label">ชื่อบริษัท</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="inputSname" placeholder="ชื่อบริษัท">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputSaddress" class="col-sm-2 control-label">หมายเลขใบสั่งซื้อ</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="inputSno" placeholder="เลขที่ หมู่ที่ หมู่บ้าน">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="inputSsoi" placeholder="ซอย">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="inputSroad" placeholder="ถนน">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputSaddress2" class="col-sm-2 control-label"></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="inputStambol" placeholder="แขวง/ตำบล">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="inputSdistrict" placeholder="เขต/อำเภอ">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="inputSprovince" placeholder="จังหวัด">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputStel" class="col-sm-2 control-label">เบอร์โทร</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="inputStel" placeholder="เบอร์โทร">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputSfax" class="col-sm-2 control-label">โทรสาร</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="inputStel" placeholder="โทรสาร">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputSemail" class="col-sm-2 control-label">อีเมลล์</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="inputSemail" placeholder="อีเมลล์">
                    </div>
                </div>
                <div class="form-group">
                    <label for="btn-save" class="col-sm-2 control-label"></label>
                    <div class="col-sm-4"><button id="btn-save" class="btn btn-green ">บันทึก</button></div>
                </div>
                        
            </form>
		</div>
    </div>
    
    <table id="table-supply" class="table-radius">
    	<thead>
            <tr>
                <th width="15%">ชื่อบริษัท</th>
                <th width="25%">ที่อยู่</th>
                <th width="20%">เบอร์โทร</th>
                <th width="20%">โทรสาร</th>
                <th width="20%">อีเมลล์</th>
            </tr>
        </thead>
        <tbody>
            <tr >
                <td>aaaa</td>
                <td>29 หมู่ 5 ต.อ้อมกอ อ.บ้านดุง จ.อุดรธานี</td>
                <td>0844094069</td>
                <td>0844094069</td>
                <td>aeglamorous@gmail.com</td>
            </tr>
             <tr>
                <td>bbbb</td>
                <td>29 หมู่ 5 ต.อ้อมกอ อ.บ้านดุง จ.อุดรธานี</td>
                <td>0844094069</td>
                <td>0844094069</td>
                <td>aeglamorous@gmail.com</td>
            </tr>
             <tr>
                <td>cccccc</td>
                <td>29 หมู่ 5 ต.อ้อมกอ อ.บ้านดุง จ.อุดรธานี</td>
                <td>0844094069</td>
                <td>0844094069</td>
                <td>aeglamorous@gmail.com</td>
            </tr>
             <tr>
                <td>sssssss</td>
                <td>29 หมู่ 5 ต.อ้อมกอ อ.บ้านดุง จ.อุดรธานี</td>
                <td>0844094069</td>
                <td>0844094069</td>
                <td>aeglamorous@gmail.com</td>
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

@stop