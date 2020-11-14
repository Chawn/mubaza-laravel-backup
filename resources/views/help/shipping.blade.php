@extends('layouts.help')
@section('css')
<style>
.text-hilight {
	color: #f16202;
}
#produce-time img{
	width: 80%;
	display: block;
	margin: 15px auto;
}
ol{
	padding-right: 50px; 
}

</style>

@stop
@section('content')
<div id="artcle">
	<p class="text-indent">
		ระยะเวลาจัดส่งสินค้า 2-10 วันทำการ โดยประมาณ ขึ้นอยู่กับพื้นที่จัดส่งสินค้า
	</p>
	<h4 class="article-title">วิธีการตรวจสอบสถานะของสินค้า</h4>
	<p class="text-indent">
		หลังจากที่ลูกค้าได้รับหมายเลขจัดส่งสินค้าแล้ว (Tacking No.) สามารถตรวจสอบสถานะของสินค้าได้ที่
	</p>
	<ul>
	    <li>ไปรษณีย์ไทย <a href="http://track.thailandpost.co.th" target="_blank">track.thailandpost.co.th</a></li>
	    <li>Kerry Express <a href="http://th.ke.rnd.kerrylogistics.com/shipmenttracking" target="_blank">www.kerryexpress.com</a></li>
	</ul>


</div>
@stop