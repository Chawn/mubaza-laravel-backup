@extends('user.layouts.dashboard')
@section('css')
<style>
    .list-group-item {
        padding:0px;
        border:none;
    }
    .list-group-item a{
        padding: 10px 15px;
        display: block;
    }
    @media(min-width: 768px) and (max-width: 991px){
        .main .container{
            padding:0px;
        }
        .wrapper-profile-box .picture {
            height: auto;
        }
    }    
</style>
@stop
@section('script')
    
@stop
@section('content')
    <div class="panel panel-default" style="">
        <div class="panel-heading">
            รายการสั่งซื้อล่าสุด
        </div>
        <div class="panel-body">
            ยังไม่มีรายการสั่งซื้อ
        </div>
    </div>

    <div class="panel panel-default" style="">
        <div class="panel-heading">
            ข้อความแจ้งเตือน
        </div>
        <div class="panel-body">
            ยังไม่มีข้อความแจ้งเตือน
        </div>
    </div>

    <div class="panel panel-default" style="">
        <div class="panel-heading">
            ชื่นชอบล่าสุด
        </div>
        <div class="panel-body">
            ยังไม่มีรายการที่ชื่นชอบ
        </div>
    </div>

    <div class="panel panel-default" style="">
        <div class="panel-heading">
            สินค้าใหม่จากครีเอเตอร์ที่คุณติดตาม
        </div>
        <div class="panel-body">
            ยังไม่มีรายการ
        </div>
    </div>
@stop