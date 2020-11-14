@extends('layouts.full_width')
@section('css')
<style>
#overview a {
	color:#999;
	}
#table-overview {
	width: 100%;
	text-align:center;	
    }
#table-overview tr {
	}
#table-overview td {
	width:30%;
	padding: 10px 0 10px 0;
	}
#table-overview li {
	list-style:none;
	display:inline;
	text-align:center;
	margin: 0 15px 0 0;
	}

#campaing-detail p {
	font-size:16px;
	display:inline;
	margin-right:5px;
	}
#campaing-detail span {
	font-size:10px;
	color:#999;
	}
#campaing-detail a {
	color:#111;
	margin-right:15px;
	}
#table-campaing-detail {
	width:100%;
	text-align:center;
	display:inline;
	}
#table-campaing-detail th {
	height:50px;
	padding-bottom:15px;
	}
#table-campaing-detail tr {
	height:70px;
	}
#table-campaing-detail td:first-child {
	width:10%;
	}
#table-campaing-detail td:last-child {
	width:10%;
	}
#table-campaing-detail td {
	width:20%;
	}
#profit-collapse td {
	width:25%;
	}
#table-campaing-detail .odd-row td{
	background:#f8f8f8;
	}
select {
	border: 1px solid transparent;
	}
</style>

<script>
$(document).ready(
    function(){
		$("#profit-collapse").hide();
        $("#a-profit").click(function () {
			$("#profit-collapse").show("slow");
			$("#profit-click-hide").hide();
        });
		$("#a-profit-collapse").click(function () {
			$("#profit-collapse").hide();
			$("#profit-click-hide").show("slow");
        });
		$("#a-profit-collapse2").click(function () {
			$("#profit-collapse").hide();
			$("#profit-click-hide").show("slow");
        });
    });
	
	$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})


 $(function() {
        /* For zebra striping */
        $("table tr:nth-child(odd)").addClass("odd-row");
});

</script>

@stop
@section('content')
<div id="user-dashboard">
    <div class="content">
        <div class="container ">
            <div id="user-setting">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title">การขายของคุณ</div>
                        <div id="overview">
                        	<table id="table-overview">
                            	<tr id="profit-click-hide">
                                	<td>
                                    	<span>จำนวนสินค้าที่สั่งซื้อ</span>
                                    	<h1>0</h1>                                        
                                    </td>
                                    <td style="border-left:1px solid #c2c9cc; border-right:1px solid #c2c9cc">
                                    	<a id="a-profit" href="#profit-collapse">กำไร</a>
                                    	<h1>0</h1>                                        
                                    </td>                                    
                                    <td>
                                    	<span>ที่ต้องจ่าย</span>
                                    	<h1>0</h1>                                        
                                    </td>
                                </tr>
                                <!-- collapes -->
                                <tr  id="profit-collapse">
                                	<td>
                                    	<span>จำนวนสินค้าที่สั่งซื้อ</span>
                                    	<h1>0</h1>                                        
                                    </td>
                                	<td style="border-left:1px solid #c2c9cc">
                                    	<a id="a-profit-collapse" href="#profit-click-hide">กำลังดำเนินการ</a>
                                    	<h1>0</h1>                        
                                    </td>
                                    <td style="border-left:1px solid #c2c9cc; border-right:1px solid #c2c9cc">
                                    	<a id="a-profit-collapse2" href="#profit-click-hide">เสร็จเรียบร้อย</a>
                                    	<h1>0</h1>                                        
                                    </td>                                    
                                    <td>
                                    	<span>ที่ต้องจ่าย</span>
                                    	<h1>0</h1>                                        
                                    </td>
                                </tr>
                                <!-- end collapes -->
                                <tr>
                                	<td colspan="4">
                                    	<ul>
                                        	<li><a href="#">วันนี้</a></li>
                                            <li><a href="#" class="active">เคลื่อนไหว</a></li>
                                            <li><a href="#">ทั้งหมด</a></li>
                                        </ul>
                                	</td>
                                </tr>
                            </table>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="title">แคมเปญของคุณ</div>
                        <div id="campaing-detail">
                        	<table id="table-campaing-detail">
                            	<thead>
                                    <tr style="border-bottom:1px solid #c2c9cc"><th colspan="6">
                                        <select class="navbar-right">
                                            <option value="1">เรียงตามวันที่จัดแคมเปญ</option>
                                            <option value="2">เรียงตามวันที่จบแคมเปญ</option>
                                            <option value="1">การซื้อ</option>
                                            <option value="4">การจอง</option>
                                            <option value="5">ชื่อ</option>
                                        </select>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($campaigns as $campaign)
                            	<tr>
                                	<td><a href=""><img src="{{ $campaign->image_front_preview }}" width="40px" height="40px"></a></td>
                                	<td><a href="#">{{ $campaign->title }}</a></td>
                                    <td><span>เหลือเวลาอยู่</span><br/><p>7</p><span>วัน</span></td>
                                    <td><span>ขายได้</span><br/><p>{{ $campaign->totalOrder() }}</p><span>ตัว</span></td>
                                    <td><span>กำไร</span><br/><p>250</p><span>บาท</span></td>
                                    <td><a href="#" class="fa fa-pencil" data-toggle="tooltip" data-placement="top"
                                           title="แก้ไข"></a> <a href="#" class="fa fa-cog" data-toggle="tooltip"
                                                                 data-placement="top" title="ตั้งค่า"></a>
                                        <a href="#" class="fa fa-files-o"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           title="ก็อปปี้"></a>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                	<td><a href="#"><img src="" width="40px" height="40px"></a></td>
                                	<td><a href="#">t-shirt mubaza za mak mak</a></td>
                                    <td><span>เหลือเวลาอยู่</span><br/><p>7</p><span>วัน</span></td>
                                    <td><span>ขายได้</span><br/><p>90</p><span>ตัว</span></td>
                                    <td><span>กำไร</span><br/><p>250</p><span>บาท</span></td>
                                    <td><a href="#" class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="แก้ไข"></a> <a href="#" class="fa fa-cog" data-toggle="tooltip" data-placement="top" title="ตั้งค่า"></a><a href="#" class="fa fa-files-o" data-toggle="tooltip" data-placement="top" title="ก็อปปี้"></a></td>
                                </tr>
                                <tr>
                                	<td><a href="#"><img src="" width="40px" height="40px"></a></td>
                                	<td><a href="#">t-shirt mubaza za mak mak</a></td>
                                    <td><span>เหลือเวลาอยู่</span><br/><p>7</p><span>วัน</span></td>
                                    <td><span>ขายได้</span><br/><p>90</p><span>ตัว</span></td>
                                    <td><span>กำไร</span><br/><p>250</p><span>บาท</span></td>
                                    <td><a href="#" class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="แก้ไข"></a> <a href="#" class="fa fa-cog" data-toggle="tooltip" data-placement="top" title="ตั้งค่า"></a><a href="#" class="fa fa-files-o" data-toggle="tooltip" data-placement="top" title="ก็อปปี้"></a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop