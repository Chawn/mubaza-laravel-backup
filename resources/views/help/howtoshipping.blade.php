@extends('layouts.help')
@section('css')
@section('content')
<style>
	.bank-img img{
		width: 50px;
	}
    .shipping-logo{
        width: 75%;
        margin:auto;
    }
    .panel-img{
        padding:15px 0;
        border-bottom: 1px solid #ddd;
        margin:25px;
    }
    p{
        text-indent: 0px !important;
    }
    .panel-body ul li{
        line-height: 30px;
    }
    a{
        word-break:break-all;
    }
</style>
<div id="artcle">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="panel">
            <div class="panel-body text-center panel-img">
                <img class="shipping-logo" src="{{ asset('images/help/logo-ems.png') }}">
            </div>
            <div class="panel-body">
                <ul>
                    <li>
                        <p>ระยะเลาจัดส่ง  1-7 วัน</p>
                    </li>
                    <li>
                        <p>ดูหมายเลข Tracking No. ได้ที่หน้าประวัติการสั่งซื้อ</p>
                    </li>
                    <li>
                        <p>ตรวจสอบสถานะพัสดุ <a href="http://track.thailandpost.co.th/tracking/default.aspx" title="">http://track.thailandpost.co.th/tracking/default.aspx</a></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="panel">
            <div class="panel-body text-center panel-img">
                <img class="shipping-logo" src="{{ asset('images/help/logo-kerry-b.png') }}">
            </div>
            <div class="panel-body">
                <ul>
                    <li>
                        <p>ระยะเวลาจัดส่ง 1-7 วัน</p>
                    </li>
                    <li>
                        <p>ดูหมายเลข Tracking No. ได้ที่หน้าประวัติการสั่งซื้อ</p>
                    </li>
                    <li>
                        <p>ตรวจสอบสถานะพัสดุ <a href="http://th.ke.rnd.kerrylogistics.com/shipmenttracking/" title="">http://th.ke.rnd.kerrylogistics.com/shipmenttracking/</a></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>	
</div>
<!-- end PAGE -->
@stop