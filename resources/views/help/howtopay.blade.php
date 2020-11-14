@extends('layouts.help')
@section('script')
<script>
    $(document).ready(function() {
        var windowWidth = $(window).width();
        if(windowWidth < 768){
            var itemWidth = $('#artcle').width();

            $('.bank-detail').width(itemWidth-64);
        }
    });
</script>
@stop
@section('css')
@section('content')
<style>
    .bank-item{
        font-weight: normal;
        margin-bottom: 15px;
    }
    .bank-img{
        vertical-align: top;
    }
	.bank-img img{
		width: 50px;
	}
    .bank-img.column{
        margin-right: 10px;
    }
    p{
        text-indent: 0px !important;
    }
    
</style>
<div id="artcle">

	{{-- <h4 class="article-title">บัญชีธนาคารสำหรับโอนเงิน</h4>
    <br>
	<label class="bank-item">  
        <div class="bank-img column">
            <img src="{{ asset('images/icon/bangkok-bank.jpg') }}">
        </div>
        <div class="bank-detail column">
            <p><strong>ธนาคารกรุงเทพ</strong></p>
            <p>เลขที่: 616-7-132742</p>
            <p>ชื่อบัญชี: ร้าน มูบาซ่า</p>
        </div>
    </label>
    <br>
    <label class="bank-item">
        <div class="bank-img column">
            <img src="{{ asset('images/icon/ktb.jpg') }}">
        </div>
        <div class="bank-detail column">
            <p><strong>ธนาคารกรุงไทย</strong></p>
            <p>เลขที่: 443-0-59537-2</p>
            <p>ชื่อบัญชี: มูบาซ่า โดย นายชาวพุทธ นวกาลัญญู</p>
        </div>
    </label>
    <br>
    <label class="bank-item">
        <div class="bank-img column">
            <img src="{{ asset('images/icon/kasikorn-bank.jpg') }}">
        </div>
        <div class="bank-detail column">
            <p><strong>ธนาคารกสิกรไทย</strong></p>
            <p>เลขที่: 512-2-51660-3</p>
            <p>ชื่อบัญชี: ร้าน มูบาซ่า</p>
        </div>
    </label>
    <br>
    <label class="bank-item">
        <div class="bank-img column">
            <img src="{{ asset('images/icon/logo-tmb.jpg') }}">
        </div>
        <div class="bank-detail column">
            <p><strong>ธนาคารทหารไทย</strong></p>
            <p>เลขที่: 465-2-23726-6</p>
            <p>ชื่อบัญชี: ร้าน มูบาซ่า โดย นายชาวพุทธ นวกาลัญญู</p>
        </div>
    </label>
    <br>


	<h4 class="article-title">แจ้งชำระเงิน</h4>
	<p class="text-indent">
		<ol>
			<li>
				แจ้งผ่านแบบฟอร์มบนเว็บ <a href="{{url('order/update-payment')}}">คลิ๊กที่นี่</a>
			</li>
			<li>
				โทรศัพท์ {{ config('profile.phone-primary') }}</a>
			</li>
			<li>
				<a href="mailto:{{ config('profile.email') }}"> Email: {{ config('profile.email') }}</a>
			</li>
		</ol>
	</p>
 --}}
     <p class="text-indent">
         ขณะนี้เปิดให้ชำระเงินเฉพาะบัตร Visa และ Master Card เท่านั้น
     </p>
	<h4 class="article-title">การเก็บรักษาข้อมูลของบัตรเครดิต</h4>
    
	<p class="text-indent">
		ความปลอดภัยของคุณคือสิ่งที่สำคัญที่สุด การดำเนินการใด ๆ เกี่ยวกับบัตรเครดิตจะเป็นไปด้วยวิธีที่ปลอดภัยที่สุด     
		มูบาซ่าจะไม่เก็บข้อมูลของบัตรเครดิตของคุณไว้หลังจากที่การดำเนินการสั่งซื้อเสร็จสิ้นแล้ว โดยข้อมูลจะถูกส่งตรงไปยังธนาคารเพื่อดำเนินการชำระเงินต่อไป 

	</p>

	<h4 class="article-title">การขอใบกำกับภาษี</h4>
	<p class="text-indent">
		กรุณาส่งคำขอของคุณมาที่ <a href="{{ action('HelpController@getContact') }}">ติดต่อเรา</a> 
	</p>
</div>
<!-- end PAGE -->
@stop