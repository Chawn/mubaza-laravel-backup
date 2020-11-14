@extends('layouts.full_width')
@section('css')
<style>
#table-user-order-header {
	width:100%;
	}
#table-user-order-header td {
	line-height:30px;
	}
#table-user-order-header span {
	font-size:16px;
	display:inline;
	font-weight:bold;
	}
#table-user-order-header p {
	font-size:16px;
	display:inline;
	margin-left:10px;
	}

#user-order-detail img{
	height: 200px;
	width: 200px;
	margin:10px 0 0 0;
	}
#user-order-detail h6 {
	font-size:18px;
	display:inline;
	}
#user-order-detail span {
	font-size:16px;
	vertical-align: text-top;
	display:inline;
	}
#user-order-detail p {
	font-size:16px;
	vertical-align: text-top;
	color:#000;
	display:inline;
	}
.table-user-order-detail {
	width:300px;
	min-height:200px;
	margin: 10px 0 10px 0;
	}
.table-user-order-detail tr:last-child {
	border-bottom:none;
	}
	
/* pricetag*/
.pricetag {
	text-align:center;
	vertical-align:middle;
	border:1px solid #ddd;
	border-radius:5px;
	width:250px;
	height:110px;
	
	margin-right:5px;
	}
.pricetag p {
	color:#7f8c8d;}
	

.loop-border-bottom {
	height:10px;
	border-bottom: 1px solid #ddd;
	}
price {
	font-size:18px;
	}
</style>
@stop
@section('content')
<div class="row">
    <div class="col-md-6 col-xs-12">
        <table id="table-user-order-header">
            <tr>
                <td><span>รหัสการสั่งซื้อ :</span><p>{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p></td>
            </tr>
            <tr>
                <td><span>วันที่สั่ง :</span><p>{{ $order->created_at }}</p></td>
            </tr>
            <tr>
                <td><span>สถานะการสั่งซื้อ :</span><p>{{ $order->status->description }}</p></td>
            </tr>
            <tr>
                <td><span>สถานะการชำระเงิน :</span><p>{{ $order->payment_status->description }}</p></td>
            </tr>
            <tr>
                <td><span>สถานะการจัดส่ง:</span><p>{{ $order->shipping_status->description }}&nbsp;{{ $order->shipping_status_id == \App\ShippingStatus::whereName('shipped') ? 'tracking no goes here' : '' }}</p></td>
            </tr>
        </table>
    </div>

    <div class="col-md-6 col-xs-12">
        <div class="pricetag navbar-right"><h2>500</h2><p>บาท</p></div>
    </div>
    <div class="col-md-12 loop-border-bottom"></div>
</div>
<div class="row">
    <div id="user-order-detail">
        <div class="col-md-6"><!-- loop -->
        <table>
            <tr>
                <td><img src="images/shirts/1960.jpg" /></td>
            </tr>                  
        </table>
        </div>    
        <div class="col-md-6">
        <table class="table-user-order-detail">
            <tr>
                <td><h6>เสื้อยืด Mubaza ผู้หญิงสีขาว </h6></td>
            </tr>
            <tr>            
                <td><span> ขนาด : </span> <p> M </p> <span> จำนวน : </span> <p> 100 </p> <span> ตัว </span></td>
            </tr>
            <tr> 
                <td><span> ขนาด : </span> <p> L </p> <span> จำนวน : </span> <p> 100 </p> <span> ตัว </span></td>
            </tr>
            <tr> 
                <td><span> ขนาด : </span> <p> XL </p> <span> จำนวน : </span> <p> 100 </p> <span> ตัว </span></td>
            </tr>
            <tr> 
                <td><price> รวม : 1200 บาท</price></td>
            </tr>       
        </table>
        </div>
        <div class="col-md-12 loop-border-bottom"></div> <!-- end loop -->
        <div class="col-md-6"><!-- loop -->
        <table class="table-user-order-detail">
            <tr>
                <td><img src="images/shirts/1960.jpg" /></td>
            </tr>                  
        </table>
        </div>    
        <div class="col-md-6">
        <table class="table-user-order-detail">
            <tr>
                <td><h6>เสื้อยืด Mubaza ผู้หญิงสีขาว </h6></td>
            </tr>
            <tr>            
                <td><span> ขนาด : </span> <p> M </p> <span> จำนวน : </span> <p> 100 </p> <span> ตัว </span></td>
            </tr>
            <tr> 
                <td><span> ขนาด : </span> <p> L </p> <span> จำนวน : </span> <p> 100 </p> <span> ตัว </span></td>
            </tr>
            <tr> 
                <td><span> ขนาด : </span> <p> XL </p> <span> จำนวน : </span> <p> 100 </p> <span> ตัว </span></td>
            </tr>
            <tr> 
                <td><price> รวม : 1200 บาท</price></td>
            </tr>       
        </table>
        </div>
        <div class="col-md-12 loop-border-bottom"></div> <!-- end loop -->
    </div>
</div>
@stop