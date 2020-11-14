@extends('layouts.full_width')
@section('css')
<style>

img.emo{
    margin: 0px 5px 5px 10px; 
    height: 150px;
}
ul{
	width: 350px;
	margin: 0 auto;
	text-align: center;
}
</style>
@stop
@section('content')
    <div id="page-informpayment" class="page-feedback">
    <div class="row">
        <div class="col-md-12 text-center">
        	<h1>คุณไม่มีสิทธิ์เข้าใช้หน้านี้</h1>

			<h3>สาเหตุอาจเกิดจาก..</h3>
			<ul >
				<li align="left">คุณพิมพ์ URL ผิด</li>
				<li align="left">หน้านี้ถูกยกเลิกการใช้งาน</li>
				<li align="left">คุณไม่มีสิทธิ์ดูหน้านี้</li>
			</ul>
	<br><br><br>
            <a href="{{ url('/') }}" title="" class="btn btn-primary">กลับไปที่หน้าแรก</a>
        </div>
    </div>
</div>
@stop