@extends('backend.layouts.master')
@section('css')
<style>
#show-img img {
	width:250px;
	margin-bottom:15px;
	}
#table-show-detail {
	width:100%;
	font-size:16px;
	margin-bottom:15px;
	}
#table-show-detail td {
	line-height:30px;
	}
#btn-edit {
	width:250px;
	}
</style>
@stop
@section('content')
<div id="show-img">
    <div class="col-md-4">
        <img src="{{ asset('images/t-shirt_02.png') }}">
        <div class="pricetag">
        	<h2>230</h2><p>ราคา (บาท)</p>
        </div>
    </div>
</div>
<div id="show-detail">
	<div class="col-md-8">
    	<table id="table-show-detail">
        	<tr>
            	<td><span>รหัสสินค้า : </span>123456</td>
            <tr>
                <td><span>ชื่อ : </span>มูบาซ่า</td>
            </tr>
            </tr>
        	<tr>
            	<td><span>หมวดหมู่ : </span>เสื้อยืด</td>
            </tr>            
            <tr>
                <td><span>ยี่ห้อ : </span>มูบาซ่า</td>
            </tr>
            <tr>
                <td><span>รายละเอียด : </span>มูบาซ่า</td>
            </tr>
        </table>
        <a id="btn-edit" class="btn btn-warning" href="http://localhost/mubaza/public/backend-products-edit">แก้ไข</a>
    </div>
</div>


@stop