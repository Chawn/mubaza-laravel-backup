@extends('backend.layouts.master')
@section('css')
<style>
@media screen and (max-width: 480px) {
.transport-detail {
	min-height:200px;
	padding:15px 0 0 0;
	border-bottom:1px solid #ddd;
	}
}
.transport-detail {
	min-height:380px;
	padding:15px 0 0 0;
	}
.transport-detail span {
	color:#2c3e50;
	}
.transport-detail img {
	width:250px;
	height:250px;
	}
.titlebar {
	border-bottom:1px solid #ddd;
	}
table {
	width:100%;
	font-size:16px;
	}
table td {
	line-height:40px;
	}
 
img {
	text-align:center;
	}
h4 {
	color:#e67e22;
	}
.well {
	background:#fff;
}
#btn-save-tracking {
	margin-top:15px;
	}
</style>


@stop
@section('content')
<div class="titlebar"><h3>รายละเอียดการจัดส่ง</h3></div>
<div class="col-md-4">
	<div class="transport-detail">
        <table>
            <tr>
                <td><img src="images/shirts/1960.jpg"></td>
            </tr>
        </table>
    </div>
</div>
<div class="col-md-4">
	<div class="transport-detail">
		<table id="table-transport-detail">
            <tr>
                <td><h4>รหัสสั่งซื้อ : 001</h4></td>
            </tr>
            <tr>
                <td>ชื่อแคมเปญ</td>
            </tr>
            <tr>
                <td>เสื้อยืดสีขาว ขนาด m 2 ตัว</td>
            </tr>
            <tr>
                <td><span>วันที่สั่งซื้อ :</span> 27-03-2558</td>
            </tr>
            <tr>
                <td><span>วันที่ผลิตเสร็จ :</span> 27-03-2558</td>
            </tr>
            <tr>
                <td><span>สถานะการจัดส่ง :</span> กำลังจัดส่ง</td>
            </tr>
            <tr>
                <td><span>หมายเลขแทรกกิ้ง :</span> </td>
            </tr>
    	</table>
    </div>	
</div>
<div class="col-md-4">
	<div class="transport-detail">
		<table id="table-customer">
            <tr>
                <td>ปรียานุช  นามมา</td>   	
            </tr>
            <tr>
                <td>ที่อยู่ : 29 หมู่ 5 ต.อ้อมกอ อ.บ้านดุง จ.อุดรธานี 41190</td>
            </tr>
            <tr><td>โทร : 0844094069</td></tr>
            <tr>
                <td>
                	<a data-toggle="collapse" href="#td-transport-status" aria-expanded="false" aria-controls="td-transport-status">แก้ไขสถานะการจัดส่ง</a>                
                </td>
            </tr>
            <tr>
                <td id="td-transport-status" class="collapse">
                	<div class="well">
                    	<div class="input-group">
                            <select class="form-control">
                                <option value="1">กำลังจัดส่ง</option>
                                <option value="2">จัดส่งเรียบร้อยแล้ว</option>
                            </select>

                            <label class="control-label">หมายเลขแทร็กกิ้ง :</label>
                            <input type="text" class="form-control" placeholder="กรอกหมายเลขแทรกกิ้ง">
                        </div>
                        <button id="btn-save-tracking" class="btn btn-green">บันทึก</button>
                    </div>
                </td>
        	</tr>
		</table>
    </div>
</div>
<div class="col-md-12" style="border-bottom:1px solid #ddd"></div>

@stop