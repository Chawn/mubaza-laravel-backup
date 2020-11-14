@extends('backend.layouts.master')
@section('css')
<style>
.titlebar {
	margin: 0 0 30px 0;
	}

/* class table radius*/
.table-radius {
	width:100%;
	}
.table-radius tr {
	text-align:center;
	line-height:40px;
	background:#fafafa;
	}
.table-radius tr:hover {
   cursor: pointer;
}
.table-radius td {
	border:1px solid #e0e0e0;
	}
.table-radius th {
	text-align:center;
	height:50px;
	vertical-align:middle;
	background:#ccc;
	border:1px solid #e0e0e0;
	}
.table-radius th:first-child {
	text-align:left;
	padding-left:20px;
	}
.table-radius td:first-child {
	text-align:left;
	padding-left:20px;
	}
.table-radius th:last-child {
	padding-right:20px;
	}
.table-radius td:last-child {
	}
.table-radius .odd-row td {
	background:#f6f6f6;
	}
.table-radius tr:hover td {
	background:#f4f4f4;
	}
.table-radius tr:hover td:last-child {
	background: none;
	}
/* end class table radius*/


</style>
<script type="text/javascript">
 $(function() {
        $("table tr:nth-child(odd)").addClass("odd-row");
});

	$(function() {
		$(".clickable-row").click(function() {
			window.document.location = $(this).data("href");
		});
});

	$(document).ready(function() { 
		$("#table-order-user-history").tablesorter(); 
	}); 
</script>
@stop

@section('content')
<div class="titlebar">
	<div class="col-md-6"><h3>ประวัติการสั่งซื้อ</h3></div>
    <div class="col-md-6" style="text-align:right;">
    	<h3>คุณ ปรียานุช นามมา</h3>
        <p>ที่อยู่ : 29 หมู่ 5 ต.อ้อมกอ อ.บ้านดุง จ.อุดรธานี 41190</p>
        <p>โทร : 0844094069</p>
    
    </div>
</div>
<table id="table-order-user-history" class="table-radius">
	<thead>
        <tr>
            <th width="15%">หมายเลขสั่งซื้อ</th>
            <th width="30%">รายการสินค้า</th>
            <th width="15%">วันที่สั่ง</th>
            <th width="10%">จำนวน</th>
            <th width="20%">สถานะการสั่งสินค้า</th>
            <th width="10%">ยอดรวม</th>
        </tr>
    </thead>
    <tbody>	
        <tr class="clickable-row" data-href="http://localhost/mubaza/public/backend-payment-order-detail">
            <td width="15%">MBZ001</td>                                
            <td width="30%"><img src#>เสื้อยือ abcd สีแดง</td>
            <td width="15%">16/03/2558</td>
            <td width="10%">1 <span>ตัว</span></td>
            <td width="20%">กำลังดำเนินการผลิต</td>
            <td width="10%">250 </td>
        </tr>
        <tr>
            <td width="15%">MBZ002</td>                                
            <td width="30%"><img src#>เสื้อยือ abcd สีแดง</td>
            <td width="15%">16/03/2558</td>
            <td width="10%">1 <span>ตัว</span></td>
            <td width="20%">กำลังดำเนินการผลิต</td>
            <td width="10%">250 </td>
        </tr>
        <tr>
            <td width="15%">MBZ003</td>                                
            <td width="30%"><img src#>เสื้อยือ abcd สีแดง</td>
            <td width="15%">16/03/2558</td>
            <td width="10%">1 <span>ตัว</span></td>
            <td width="20%">กำลังดำเนินการผลิต</td>
            <td width="10%">250 </td>
        </tr>
        <tr>
            <td width="15%">MBZ004</td>                                
            <td width="30%"><img src#>เสื้อยือ abcd สีแดง</td>
            <td width="15%">16/03/2558</td>
            <td width="10%">1 <span>ตัว</span></td>
            <td width="20%">กำลังดำเนินการผลิต</td>
            <td width="10%">250 </td>
        </tr>
        <tr>
            <td width="15%">MBZ001</td>                                
            <td width="30%"><img src#>เสื้อยือ abcd สีแดง</td>
            <td width="15%">16/03/2558</td>
            <td width="10%">1 <span>ตัว</span></td>
            <td width="20%">กำลังดำเนินการผลิต</td>
            <td width="10%">250 </td>
        </tr>
        <tr>
            <td width="15%">MBZ001</td>                                
            <td width="30%"><img src#>เสื้อยือ abcd สีแดง</td>
            <td width="15%">16/03/2558</td>
            <td width="10%">1 <span>ตัว</span></td>
            <td width="20%">กำลังดำเนินการผลิต</td>
            <td width="10%">250 </td>
        </tr>
        <tr>
            <td width="15%">MBZ001</td>                                
            <td width="30%"><img src#>เสื้อยือ abcd สีแดง</td>
            <td width="15%">16/03/2558</td>
            <td width="10%">1 <span>ตัว</span></td>
            <td width="20%">กำลังดำเนินการผลิต</td>
            <td width="10%">250 </td>
        </tr> 
	</tbody>             
</table>

@stop