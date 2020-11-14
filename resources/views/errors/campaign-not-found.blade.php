@extends('layouts.full_width')
@section('css')
<style>

img.emo{
    margin: 0px 5px 5px 10px; 
    height: 150px;
}
#error-list{
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
            <h1>ไม่พบแคมเปญนี้ในระบบ </h1>
            <img class="emo" src="../images/icon/cat.png" alt="">
			<h3>สาเหตุอาจเกิดจาก..</h3>
			<ul id="error-list">
				<li align="left">คุณพิมพ์ URL ผิด</li>
				<li align="left">แคมเปญถูกปิดโดยเจ้าของแคมเปญ</li>
				<li align="left">แคมเปญถูกระงับ เนื่องจากการละเมิดลิขสิทธิ์</li>
				<li align="left">แคมเปญถูกระงับ เนื่องจากมีเนื้อหาไม่เหมาะสม</li>
			</ul>
	<br><br><br>
            <a href="{{ url('/') }}" title="" class="btn btn-primary">กลับไปที่หน้าแรก</a>
        </div>
    </div>
</div>
@stop