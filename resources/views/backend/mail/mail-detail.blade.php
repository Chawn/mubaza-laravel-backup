@extends('backend.layouts.master')
@section('css')
<style>
#mail-header {
	margin:  0 0 15px 0;
	}

#mail-detali {
	margin-top:15px;
	border-top:1px solid #ddd;
	padding:15px 0 15px 0;
	border-bottom:1px solid #ddd;
	}
#mail-textarea {
	margin:15px 0 15px 0;
	}
#mail-reply {
	margin:15px 0 0 0;
	}
.mail-before {
	background:#f5f5f5;
	min-height:60px;
	border-bottom:1px solid #ddd;
	padding:10px ;
	}


.mail-detail {
	width:100%;
	}
.mail-detail td:first-child {
	vertical-align:top;
	}
.mail-detail td:last-child {
	vertical-align:top;
	}
.mail-detail td:nth-child(2) {
	text-align:left;
	}

.media {
	padding: 10px;
	margin-top: 0px;
}
.media-left {
	width: 100px;
	max-height: 100px;
}
.media-img {
	width: 80px;
	height: 80px;
	display: block;
	overflow: hidden;
	border: 1px solid #ddd;
}
.media-img img {
	width: 80px;
}
.media-body span {
	font-size: 14px;
	float: right;
}
</style>

@stop
@section('content')
<div id="mail-header">
	<h3>สวัสดีค่ะ</h3>
</div>
<div class="col-md-12">
	<div class="media mail-before ">
		<div class="media-left">
			<div class="media-img" onclick="location.href='#';">
				<img class="" src="{{asset('images/patty_n.png')}}">
			</div>
		</div>
		<div class="media-body">
			<h4 class="media-heading">
				<a href="#">อารยา</a> 
				<span>12-12-24 16:59</span>
			</h4>
			สวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลก
		</div>
	</div>
	<div class="media mail-before ">
		<div class="media-left">
			<div class="media-img" onclick="location.href='#';">
				<img class="" src="{{asset('images/patty_n.png')}}">
			</div>
		</div>
		<div class="media-body">
			<h4 class="media-heading">
				<a href="#">อารยา</a> 
				<span>12-12-24 16:59</span>
			</h4>
			สวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลก
		</div>
	</div>
	<div class="media">
		<div class="media-left">
			<div class="media-img" onclick="location.href='#';">
				<img class="" src="{{asset('images/patty_n.png')}}">
			</div>
		</div>
		<div class="media-body">
			<h4 class="media-heading">
				<a href="#">อารยา</a> 
				<span>12-12-24 16:59</span>
			</h4>
			สวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลกสวัสดีชาวโลก
		</div>
	</div>
</div>

<div class="col-md-12">
	<div id="mail-textarea">
    	<textarea rows="4" class="form-control">
        </textarea>
        <button id="mail-reply" class="btn btn-green pull-right">ตอบกลับ</button>
    </div>
</div>

@stop